<?php

namespace AW\NewsletterBundle\Doctrine;

use AW\NewsletterBundle\Model\NewsletterManager as BaseNewsletterManager;
use AW\NewsletterBundle\Model\SubscriberInterface;

use Doctrine\Common\Persistence\ObjectManager;

/**
 * NewsletterManager.
 *
 * @author Adam Wójs <adam@wojs.pl>
 */
class NewsletterManager extends BaseNewsletterManager
{
    protected $om;
    protected $repository;
    protected $class;

    public function __construct(ObjectManager $om, $class)
    {
        $this->om = $om;
        $this->repository = $om->getRepository($class);
        $this->class = $om->getClassMetadata($class)->getName();
    }

    /**
     * {@inheritdoc}
     */
    public function findByEmail($email)
    {
        return $this->repository->findOneBy(['email' => $email]);
    }

    /**
     * {@inheritdoc}
     */
    public function findByEmailHash($hash)
    {
        return $this->repository->findOneBy(['emailHash' => $hash]);
    }

    /**
     * {@inheritdoc}
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * {@inheritdoc}
     */
    public function subscribe(SubscriberInterface $subscriber, $flush = true)
    {
        $subscriber->setEmailHash($this->generateEmailHash($subscriber->getEmail()));

        $this->om->persist($subscriber);

        if ($flush) {
            $this->om->flush();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function unsubscribe(SubscriberInterface $subscriber, $flush = true)
    {
        $this->om->remove($subscriber);

        if ($flush) {
            $this->om->flush();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function confirm(SubscriberInterface $subscriber, $flush = true)
    {
        if (!$subscriber->isConfirmed()) {
            $subscriber->setConfirmed(true);

            if ($flush) {
                $this->om->flush();
            }
        }
    }
}
