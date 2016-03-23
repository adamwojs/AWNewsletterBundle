<?php

namespace AW\NewsletterBundle\Mailer;

use AW\NewsletterBundle\Model\SubscriberInterface;

/**
 * MailerInterface.
 *
 * @author Adam Wójs <adam@wojs.pl>
 */
interface MailerInterface
{
    /**
     *
     * @param SubscriberInterface $subscriber
     * @return void
     */
    public function sendWelcomeEmailMessage(SubscriberInterface $subscriber);

    /**
     *
     * @param SubscriberInterface $subscriber
     * @return void
     */
    public function sendConfirmationEmailMessage(SubscriberInterface $subscriber);
}
