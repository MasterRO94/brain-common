<?php

namespace Brain\Common\Workflow\Builder;

use Brain\Common\Workflow\WorkflowBuilderInterface;

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
abstract class AbstractWorkflowBuilder implements WorkflowBuilderInterface
{
    private $eventDispatcher;

    /**
     * Return the name of the property that state will affect.
     *
     * @return string
     */
    abstract public function getStatePropertyName(): string;

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
     * {@inheritdoc}
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
