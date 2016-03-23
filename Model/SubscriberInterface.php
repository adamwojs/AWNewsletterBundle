<?php

namespace AW\NewsletterBundle\Model;

/**
 * Subscriber interface.
 *
 * @author Adam Wójs <adam@wojs.pl>
 */
interface SubscriberInterface
{
    /**
     * Returns email
     *
     * @return string
     */
    public function getEmail();

    /**
     * Returns email hash
     *
     * @return string
     */
    public function getEmailHash();

    /**
     * Subscriber confirms email ?
     *
     * @return boolean
     */
    public function isConfirmed();

    /**
     * Email setter
     *
     * @param string $email
     * @return void
     */
    public function setEmail($email);

    /**
     * Email hash setter
     *
     * @param string $email
     * @return void
     */
    public function setEmailHash($hash);

    /**
     * Confirmation setter
     *
     * @param bool $confirmed
     * @return void
     */
    public function setConfirmed($confirmed);

}
