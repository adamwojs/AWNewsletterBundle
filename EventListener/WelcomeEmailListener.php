<?php

namespace AW\NewsletterBundle\EventListener;

use AW\NewsletterBundle\Event\NewsletterEvent;
use AW\NewsletterBundle\Event\NewsletterEvents;
use AW\NewsletterBundle\Mailer\MailerInterface;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * WelcomeEmailListener.
 *
 * @author Adam Wójs <adam@wojs.pl>
 */
class WelcomeEmailListener implements EventSubscriberInterface
{
    /**
     * @var MailerInterface
     */
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function onSubscribeCompleted(NewsletterEvent $event)
    {
        $subscriber = $event->getSubscriber();

        if ($subscriber->isConfirmed()) {
            $this->mailer->sendWelcomeEmailMessage($subscriber);
        }
    }

    public function onSubscribeConfirmed(NewsletterEvent $event)
    {
        $this->mailer->sendWelcomeEmailMessage($event->getSubscriber());
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            NewsletterEvents::SUBSCRIBE_COMPLETED => ['onSubscribeCompleted', 100],
            NewsletterEvents::SUBSCRIBE_CONFIRMED => 'onSubscribeConfirmed'
        ];
    }
}
