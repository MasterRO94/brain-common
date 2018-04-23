<?php

namespace Brain\Common\Workflow;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Workflow\Definition;
use Symfony\Component\Workflow\MarkingStore\SingleStateMarkingStore;
use Symfony\Component\Workflow\Transition;
use Symfony\Component\Workflow\Workflow;

/**
 * An implementation of workflow that doesn't involve the service container.
 *
 * @api
 */
abstract class AbstractWorkflowBuilder
{
    private $eventDispatcher;

    /**
     * Constructor.
     *
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * Return the name of the workflow.
     *
     * @return string
     *
     * @api
     */
    abstract public static function getName(): string;

    /**
     * Return the name of the property that state will affect.
     *
     * @return string
     *
     * @api
     */
    abstract public function getStatePropertyName(): string;

    /**
     * Return the available states.
     *
     * @return string[]
     *
     * @api
     */
    abstract public function getAvailableStates(): array;

    /**
     * Return the transitions.
     *
     * @return Transition[]
     *
     * @api
     */
    abstract public function getTransitions(): array;

    /**
     * Build the workflow object.
     *
     * @return Workflow
     */
    final public function build(): Workflow
    {
        return new Workflow(
            new Definition(
                $this->getAvailableStates(),
                $this->getTransitions()
            ),
            new SingleStateMarkingStore(
                $this->getStatePropertyName()
            ),
            $this->eventDispatcher,
            static::getName()
        );
    }

    /**
     * Expand the from array to individual transitions.
     *
     * @param string $name
     * @param string[] $from
     * @param string $to
     *
     * @return Transition[]
     */
    final protected function expand(string $name, array $from, string $to): array
    {
        return array_map(function ($from) use ($name, $to) {
            return new Transition($name, $from, $to);
        }, $from);
    }
}
