<?php

declare(strict_types=1);

namespace Brain\Common\Event;

use Symfony\Component\EventDispatcher\Event;

/**
 * An event that knows its event name.
 *
 * {@inheritdoc}
 */
abstract class AbstractEvent extends Event
{
    /**
     * Return the event name.
     */
    abstract public static function getEventName(): string;
}
