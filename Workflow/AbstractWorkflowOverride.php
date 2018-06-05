<?php

namespace Brain\Common\Workflow;

use Brain\Bundle\Core\Workflow\AbstractStatusWorkflowManager;
use Brain\Common\Workflow\Builder\AbstractWorkflowBuilder;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Workflow\Event\Event;

/**
 * A helper class for cases where a job may need to undergo two transitions
 * in a row preventing any other "completed" listeners from firing for the first
 * transition.
 *
 * @api
 */
abstract class AbstractWorkflowOverride implements EventSubscriberInterface
{
    const WORKFLOW_EVENT = 'completed';

    /**
     * The singleton instance of this class.
     *
     * @var AbstractWorkflowOverride $instance
     */
    protected static $instance;

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
        if (static::$instance) {
            throw new \Exception(sprintf(
                "%s already instantiated.",
                get_class($this)
            ));
        }
        $this->manager = $manager;
        $this->reason = $reason;
        static::$instance = $this;
    }

    /**
     * Return a list of transitions for which to listen.
     *
     * @return string[]
     *
     * @api
     */
    abstract public static function getAnteriorTransitions(): array;

    /**
     * Return the transition to apply subsequently.
     *
     * @param string $anteriorTransition
     * @return string
     *
     * @api
     */
    abstract protected function getPosteriorTransition(string $anteriorTransition): string;

    /**
     * Does this override apply for the given event?
     *
     * @param Event $event
     * @return bool
     *
     * @api
     */
    abstract protected function shouldApply(Event $event): bool;

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        $events = [];

        foreach (static::getAnteriorTransitions() as $transition) {
            $event = sprintf(
                'workflow.%s.%s.%s',
                static::$instance->manager->getBuilderName(),
                static::WORKFLOW_EVENT,
                $transition
            );
            $events[$event] = [['handle',],];
        }

        return $events;
    }

    /**
     * The event listener. Calls shouldApply() and getPosteriorTransition().
     * @param Event $event
     */
    public function handle(Event $event)
    {
        if ($this->shouldApply($event)) {
            $job = $event->getSubject();
            $this->manager->progressTransition(
                $job,
                $this->getPosteriorTransition($event->getTransition()),
                $this->reason
            );
        }
    }
}
