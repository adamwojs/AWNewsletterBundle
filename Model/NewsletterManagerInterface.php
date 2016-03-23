<?php

namespace AW\NewsletterBundle\Model;

/**
 * NewsletterManagerInterface.
 *
 * @author Adam Wójs <adam@wojs.pl>
 */
interface NewsletterManagerInterface
{
    /**
     * Returns an empty newsletter subscriber instance
     *
     * @return SubscriberInterface
     */
    public function createSubscriber();

    /**
     * Find subscriber by email
     *
     * @param string $email
     * @return SubscriberInterface
     */
    public function findByEmail($email);

    /**
     * Find subscriber by email hash
     *
     * @param string $hash
     * @return SubscriberInterface
     */
    public function findByEmailHash($hash);

    /**
     * Returns the newsletter subscriber's fully qualified class name.
     *
     * @return string
     */
    public function getClass();

    /**
     * Add subscriber to newsletter.
     *
     * @param SubscriberInterface $subscriber
     */
    public function subscribe(SubscriberInterface $subscriber);

    /**
     *
     *
     * @param SubscriberInterface $subscriber
     */
    public function unsubscribe(SubscriberInterface $subscriber);

    /**
     *
     * @param SubscriberInterface $subscriber
     */
    public function confirm(SubscriberInterface $subscriber);
}
