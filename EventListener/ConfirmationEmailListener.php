<?php

namespace AW\NewsletterBundle\EventListener;

use AW\NewsletterBundle\Event\NewsletterEvent;
use AW\NewsletterBundle\Event\NewsletterEvents;
use AW\NewsletterBundle\Mailer\MailerInterface;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * ConfirmationEmailListener.
 *
 * @author Adam Wójs <adam@wojs.pl>
 */
class ConfirmationEmailListener implements EventSubscriberInterface
{
    /**
     * @var MailerInterface
     */
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function onSubscribeSuccess(NewsletterEvent $event)
    {
        $subscriber = $event->getSubscriber();
        $subscriber->setConfirmed(false);
    }

    public function onSubscribeCompleted(NewsletterEvent $event)
    {
        $this->mailer->sendConfirmationEmailMessage($event->getSubscriber());
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            NewsletterEvents::SUBSCRIBE_SUCCESS => ['onSubscribeSuccess', 10],
            NewsletterEvents::SUBSCRIBE_COMPLETED => 'onSubscribeCompleted'
        ];
    }
}
