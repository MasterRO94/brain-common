<?php

namespace Brain\Common\Event;

use Symfony\Component\EventDispatcher\Event;

/**
 * An event that knows its event name.
 *
 * {@inheritdoc}
 *
 * @api
 */
abstract class AbstractEvent extends Event
{
    /**
     * Return the event name.
     *
     * @return string
     *
     * @api
     */
    abstract public static function getEventName(): string;
}
