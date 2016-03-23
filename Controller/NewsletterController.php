<?php

namespace AW\NewsletterBundle\Controller;

use AW\NewsletterBundle\Event\NewsletterEvent;
use AW\NewsletterBundle\Event\NewsletterEvents;
use AW\NewsletterBundle\Model\NewsletterManagerInterface;
use AW\NewsletterBundle\Model\SubscriberInterface;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * NewsletterController.
 *
 * @author Adam Wójs <adam@wojs.pl>
 */
class NewsletterController extends Controller
{
    /**
     * Subskrybcja newslettera.
     *
     * @param Request $request
     * @return Respsonse
     */
    public function subscribeAction(Request $request)
    {
        $form = $this->createNewsletterForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $subscriber = $form->getData();

            $this->handleSubscription($subscriber);

            return $this->render('AWNewsletterBundle:newsletter:subscriped.html.twig', [
                'subscriber' => $subscriber
            ]);
        }

        return $this->render('AWNewsletterBundle:newsletter:form.html.twig', [
            'form' => $form->createView()
        ]);
    }

    protected function handleSubscription(SubscriberInterface $subscriber)
    {
        $subscriber->setConfirmed(true);

        $this->getEventDispatcher()->dispatch(
            NewsletterEvents::SUBSCRIBE_SUCCESS,
            new NewsletterEvent($subscriber)
        );

        $manager = $this->getNewsletterManager();
        $manager->subscribe($subscriber);

        $this->getEventDispatcher()->dispatch(
            NewsletterEvents::SUBSCRIBE_COMPLETED,
            new NewsletterEvent($subscriber)
        );
    }

    /**
     * Subscription confirmation.
     *
     * @param Request $request
     * @param string $hash
     * @return Response
     */
    public function confirmAction(Request $request, $hash)
    {
        $manager = $this->getNewsletterManager();

        $subscriber = $manager->findByEmailHash($hash);
        if ($subscriber instanceof SubscriberInterface) {
            if (!$subscriber->isConfirmed()) {
                $this->handleConfirmation($subscriber);
            }

            return $this->createConfirmationSuccessResponse($request, $subscriber);
        }

        throw $this->createNotFoundException("Invalid subscription confirmation token.");
    }

    protected function createConfirmationSuccessResponse(
        Request $request,
        SubscriberInterface $subscriber)
    {
        return $this->render('AWNewsletterBundle:newsletter:confirmed.html.twig', [
            'subscriber' => $subscriber
        ]);
    }

    protected function handleConfirmation(SubscriberInterface $subscriber)
    {
        $manager = $this->getNewsletterManager();
        $manager->confirm($subscriber);

        $this->getEventDispatcher()->dispatch(
            NewsletterEvents::SUBSCRIBE_CONFIRMED,
            new NewsletterEvent($subscriber)
        );
    }

    /**
     * Wypisanie się z newslettera.
     *
     * @param Request $request
     * @param string $hash Adres e-mail użytkowanika
     * @return Response
     */
    public function unsubscribeAction(Request $request, $hash)
    {
        $manager = $this->getNewsletterManager();

        $subscriber = $manager->findByEmailHash($hash);
        if ($subscriber instanceof SubscriberInterface) {
            $this->handleUnsubscription($subscriber);

            return $this->createUnsubscribeSuccessResponse($request, $subscriber);
        }

        throw $this->createNotFoundException("Invalid subscription unsubscribe token.");
    }

    protected function createUnsubscribeSuccessResponse(
        Request $request,
        SubscriberInterface $subscriber)
    {
        return $this->render('AWNewsletterBundle:newsletter:unsubscribed.html.twig', [
            'subscriber' => $subscriber
        ]);
    }

    protected function handleUnsubscription(SubscriberInterface $subscriber)
    {
        $manager = $this->getNewsletterManager();
        $manager->unsubscribe($subscriber);

        $this->getEventDispatcher()->dispatch(
            NewsletterEvents::SUBSCRIBE_CANCEL,
            new NewsletterEvent($subscriber)
        );
    }

    /**
     * Create newsletter form.
     *
     * @return FormInterface
     */
    protected function createNewsletterForm()
    {
        return $this->get('aw_newsletter.newsletter.form');
    }

    /**
     * @return EventDispatcherInterface
     */
    protected function getEventDispatcher()
    {
        return $this->get('event_dispatcher');
    }

    /**
     * @return NewsletterManagerInterface
     */
    protected function getNewsletterManager()
    {
        return $this->get('aw_newsletter.newsletter_manager');
    }
}
