<?php

namespace AW\NewsletterBundle\Model;

/**
 * Base subscriber model.
 *
 * @author Adam Wójs <adam@wojs.pl>
 */
abstract class Subscriber implements SubscriberInterface
{
    /** @var string */
    protected $email;

    /** @var string */
    protected $emailHash;

    /** @var bool */
    protected $confirmed;

    /**
     * {@inheritdoc}
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * {@inheritdoc}
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * {@inheritdoc}
     */
    public function getEmailHash()
    {
        return $this->emailHash;
    }

    /**
     * {@inheritdoc}
     */
    public function setEmailHash($hash)
    {
        $this->emailHash = $hash;
    }

    /**
     * {@inheritdoc}
     */
    public function isConfirmed()
    {
        return $this->confirmed;
    }

    /**
     * {@inheritdoc}
     */
    public function setConfirmed($confirmed)
    {
        $this->confirmed = $confirmed;
    }
}
