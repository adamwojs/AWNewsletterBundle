<?php

namespace AW\NewsletterBundle\Model;

/**
 * NewsletterManager.
 *
 * @author Adam Wójs <adam@wojs.pl>
 */
abstract class NewsletterManager implements NewsletterManagerInterface
{
    /**
     * {@inheritdoc}
     */
    public function createSubscriber()
    {
        $class = $this->getClass();
        $subscriber = new $class;

        return $subscriber;
    }

    public function generateEmailHash($email)
    {
        return md5($email);
    }

}
