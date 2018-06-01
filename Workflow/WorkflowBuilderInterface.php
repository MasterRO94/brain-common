<?php

namespace Brain\Common\Workflow;

use Symfony\Component\Workflow\Workflow;

interface WorkflowBuilderInterface
{
    /**
     * Return the name of the workflow.
     *
     * @return string
     *
     * @api
     */
    public static function getName(): string;

    /**
     * Return the available states.
     *
     * @return string[]
     *
     * @api
     */
    public function getAvailableStates(): array;

    /**
     * Return the transitions.
     *
     * @return Transition[]
     *
     * @api
     */
    public function getTransitions(): array;

    /**
     * Build the workflow object.
     *
     * @return Workflow
     */
    public function build(): Workflow;
}
