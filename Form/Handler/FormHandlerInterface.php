<?php

declare(strict_types=1);

namespace Brain\Common\Form\Handler;

use Brain\Common\Form\Exception\FormValidationException;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

interface FormHandlerInterface
{
    /**
     * Create and handle the form for the request.
     *
     * @param mixed $data
     * @param mixed[] $options
     *
     * @throws FormValidationException When form fails validation.
     */
    public function manage(string $type, $data = null, array $options = [], ?Request $request = null): FormInterface;

    /**
     * Create and handle a form in in partial.
     *
     * @param null $data
     * @param mixed[] $options
     */
    public function partial(string $type, $data = null, array $options = [], ?Request $request = null): FormInterface;

    /**
     * Handle the form for the given payload.
     *
     * @param mixed[] $payload
     * @param mixed $data
     * @param mixed[] $options
     *
     * @throws FormValidationException When form fails validation.
     */
    public function handle(string $type, array $payload, $data = null, array $options = [], bool $missing = true): FormInterface;
}
