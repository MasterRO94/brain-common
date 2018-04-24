<?php

namespace Brain\Common\Form\Handler;

use Brain\Bundle\Core\Exception\FormValidationException;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

interface FormHandlerInterface
{
    /**
     * Create and handle the form for the request.
     *
     * @param string $type
     * @param mixed $data
     * @param array $options
     * @param Request|null $request
     *
     * @throws FormValidationException when form fails validation.
     *
     * @return FormInterface
     */
    public function manage(string $type, $data = null, array $options = [], Request $request = null): FormInterface;

    /**
     * Create and handle a form in in partial.
     *
     * @param string $type
     * @param null $data
     * @param array $options
     * @param Request|null $request
     *
     * @return FormInterface
     */
    public function partial(string $type, $data = null, array $options = [], Request $request = null): FormInterface;

    /**
     * Handle the form for the given payload.
     *
     * @param string $type
     * @param array $payload
     * @param null $data
     * @param array $options
     *
     * @throws FormValidationException when form fails validation.
     *
     * @return FormInterface
     */
    public function handle(string $type, array $payload, $data = null, array $options = []): FormInterface;
}
