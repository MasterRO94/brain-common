<?php

declare(strict_types=1);

namespace Brain\Common\Workflow;

use Brain\Bundle\Core\Workflow\AbstractStatusWorkflowManager;
use Brain\Bundle\Job\Database\EntityInterface\JobInterface;

use Brain\Common\Workflow\Builder\AbstractWorkflowBuilder;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Workflow\Event\Event;

/**
 * A helper class for cases where a job may need to undergo two transitions
 * in a row preventing any other "completed" listeners from firing for the first
 * transition.
 */
abstract class AbstractWorkflowOverride implements EventSubscriberInterface
{
    public const WORKFLOW_EVENT = 'completed';

    /**
     * Return the class name of the workflow builder.
     */
    abstract public static function getWorkflowBuilderClass(): string;

    /**
     * The workflow manager on which we will call progressByStatus.
     *
     * @var AbstractStatusWorkflowManager $manager
     */
    protected $manager;

    /**
     * The reason the posterior transition is applied.
     *
     * @var string $reason
     */
    protected $reason;

    public function __construct(
        AbstractStatusWorkflowManager $manager,
        string $reason
    ) {
        $this->manager = $manager;
        $this->reason = $reason;
    }

    /**
     * Return a list of transitions for which to listen.
     *
     * @return string[]
     */
    abstract public static function getAnteriorTransitions(): array;

    /**
     * Return the transition to apply subsequently.
     */
    abstract protected function getPosteriorTransition(string $anteriorTransition): string;

    /**
     * Does this override apply for the given event?
     */
    abstract protected function shouldApply(Event $event): bool;

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        $events = [];

        /** @var AbstractWorkflowBuilder $workflow */
        $workflow = static::getWorkflowBuilderClass();

        foreach (static::getAnteriorTransitions() as $transition) {
            $event = sprintf(
                'workflow.%s.%s.%s',
                $workflow::getName(),
                self::WORKFLOW_EVENT,
                $transition
            );
            $events[$event] = [['handle']];
        }

        return $events;
    }

    /**
     * The event listener. Calls shouldApply() and getPosteriorTransition().
     */
    public function handle(Event $event): void
    {
        if (!$this->shouldApply($event)) {
            return;
        }

        /** @var JobInterface $job */
        $job = $event->getSubject();
        $this->manager->progressTransition(
            $job,
            $this->getPosteriorTransition($event->getTransition()->getName()),
            $this->reason
        );
    }
}
