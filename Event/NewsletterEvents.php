<?php

namespace AW\NewsletterBundle\Event;

/**
 * NewsletterEvents.
 *
 * @author Adam Wójs <adam@wojs.pl>
 */
final class NewsletterEvents
{
    const SUBSCRIBE_INITIALIZE = 'aw_newsletter.subscribe.initialize';

    const SUBSCRIBE_COMPLETED = 'aw_newsletter.subscribe.completed';

    const SUBSCRIBE_SUCCESS = 'aw_newsletter.subscribe.success';

    const SUBSCRIBE_CONFIRMED = 'aw_newsletter.subscribe.confirmed';

    const SUBSCRIBE_CANCEL = 'aw_newsletter.subscribe.cancel';
}
