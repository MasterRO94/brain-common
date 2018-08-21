<?php

declare(strict_types=1);

namespace Brain\Common\Workflow;

use Symfony\Component\Workflow\Transition;
use Symfony\Component\Workflow\Workflow;

interface WorkflowBuilderInterface
{
    /**
     * Return the name of the workflow.
     */
    public static function getName(): string;

    /**
     * Return the available states.
     *
     * @return string[]
     */
    public function getAvailableStates(): array;

    /**
     * Return the transitions.
     *
     * @return Transition[]
     */
    public function getTransitions(): array;

    /**
     * Build the workflow object.
     */
    public function build(): Workflow;
}
