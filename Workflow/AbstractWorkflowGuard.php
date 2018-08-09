<?php

declare(strict_types=1);

namespace Brain\Common\Workflow;

use Brain\Common\Workflow\Builder\AbstractWorkflowBuilder;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * A workflow guard helper.
 */
abstract class AbstractWorkflowGuard implements EventSubscriberInterface
{
    /**
     * Return the class name of the workflow builder.
     */
    abstract public static function getWorkflowBuilderClass(): string;

    /**
     * Return the guarded states and the name of the function needed to be called.
     *
     * @return string[]
     */
    abstract public static function getGuardedTransitions(): array;

    /**
     * {@inheritdoc}
     */
    final public static function getSubscribedEvents()
    {
        $events = [];

        /** @var AbstractWorkflowBuilder $workflow */
        $workflow = static::getWorkflowBuilderClass();

        foreach (static::getGuardedTransitions() as $transition => $guards) {
            $event = sprintf('workflow.%s.guard.%s', $workflow::getName(), $transition);
            $events[$event] = $guards;
        }

        return $events;
    }
}
