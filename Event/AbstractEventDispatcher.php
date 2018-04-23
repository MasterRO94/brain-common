<?php

namespace Brain\Common\Event;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * An event dispatcher that can dispatch event classes.
 *
 * {@inheritdoc}
 *
 * @api
 */
abstract class AbstractEventDispatcher
{
    private $dispatcher;

    /**
     * Constructor.
     *
     * @param EventDispatcherInterface $dispatcher
     */
    public function __construct(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * Dispatch an event class.
     *
     * @param AbstractEvent $event
     */
    final protected function dispatch(AbstractEvent $event)
    {
        $this->dispatcher->dispatch(
            $event::getEventName(),
            $event
        );
    }
}
