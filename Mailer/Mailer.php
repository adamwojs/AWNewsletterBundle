<?php

namespace AW\NewsletterBundle\Mailer;

use AW\NewsletterBundle\Model\SubscriberInterface;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Templating\EngineInterface;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Mailer.
 *
 * @author Adam Wójs <adam@wojs.pl>
 */
class Mailer implements MailerInterface
{
    protected $mailer;
    protected $router;
    protected $templating;
    protected $translator;
    protected $parameters;

    public function __construct(
        \Swift_Mailer $mailer,
        UrlGeneratorInterface $router,
        EngineInterface $templating,
        TranslatorInterface $translator,
        array $parameters)
    {
        $this->mailer = $mailer;
        $this->router = $router;
        $this->templating = $templating;
        $this->translator = $translator;
        $this->parameters = $parameters;
    }

    /**
     * {@inheritdoc}
     */
    public function sendWelcomeEmailMessage(SubscriberInterface $subscriber)
    {
        $subject = $this->translator->trans('welcome.email.subject', [], 'AWNewsletterBundle');
        $content = $this->templating->render('AWNewsletterBundle:email:welcome.html.twig', [
            'subscriber' => $subscriber
        ]);

        /* @var $message \Swift_Mime_Message */
        $message = $this->mailer->createMessage();
        $message->setSubject($subject);
        $message->setFrom(
            $this->parameters['welcome']['sender']['address'],
            $this->parameters['welcome']['sender']['name']
        );
        $message->setTo($subscriber->getEmail());
        $message->setBody($content, 'text/html');

        $this->mailer->send($message);
    }

    /**
     * {@inheritdoc}
     */
    public function sendConfirmationEmailMessage(SubscriberInterface $subscriber)
    {
        $subject = $this->translator->trans('confirmation.email.subject', [], 'AWNewsletterBundle');
        $content = $this->templating->render('AWNewsletterBundle:email:confirmation.html.twig', [
            'subscriber' => $subscriber
        ]);

        /* @var $message \Swift_Mime_Message */
        $message = $this->mailer->createMessage();
        $message->setSubject($subject);
        $message->setFrom(
            $this->parameters['confirmation']['sender']['address'],
            $this->parameters['confirmation']['sender']['name']
        );
        $message->setTo($subscriber->getEmail());
        $message->setBody($content, 'text/html');

        $this->mailer->send($message);
    }
}
