<?php

declare(strict_types=1);

namespace Brain\Common\Event;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * An event dispatcher that can dispatch event classes.
 */
abstract class AbstractEventDispatcher
{
    /** @var EventDispatcherInterface */
    private $dispatcher;

    public function __construct(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * Dispatch an event class.
     */
    final protected function dispatch(AbstractEvent $event): void
    {
        $this->dispatcher->dispatch(
            $event::getEventName(),
            $event
        );
    }
}
