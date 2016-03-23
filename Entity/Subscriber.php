<?php

namespace AW\NewsletterBundle\Entity;

use AW\NewsletterBundle\Model\Subscriber as BaseSubscriber;

/**
 * Subscriber.
 *
 * @author Adam Wójs <adam@wojs.pl>
 */
class Subscriber extends BaseSubscriber {

    /**
     * @var integer
     */
    protected $id;

    public function getId()
    {
        return $this->id;
    }
}
