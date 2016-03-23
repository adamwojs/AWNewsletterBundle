<?php

namespace AW\NewsletterBundle\Event;

use AW\NewsletterBundle\Model\SubscriberInterface;

use Symfony\Component\EventDispatcher\Event;

/**
 * NewsletterEvent.
 *
 * @author Adam Wójs <adam@wojs.pl>
 */
class NewsletterEvent extends Event
{
    /**
     * @var SubscriberInterface
     */
    private $subscriber;

    public function __construct(SubscriberInterface $subscriber)
    {
        $this->subscriber = $subscriber;
    }

    public function getSubscriber()
    {
        return $this->subscriber;
    }
}
