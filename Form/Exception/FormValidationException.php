<?php

declare(strict_types=1);

namespace Brain\Common\Form\Exception;

use Brain\Common\Exception\AbstractBrainRuntimeException;

use Symfony\Component\Form\FormInterface;

/**
 * A form validation exception.
 */
final class FormValidationException extends AbstractBrainRuntimeException implements
    FormValidationExceptionInterface
{
    private $form;

    public function __construct(FormInterface $form)
    {
        parent::__construct('The form did not pass validation', null);

        $this->form = $form;
    }

    /**
     * {@inheritdoc}
     */
    public function getForm(): FormInterface
    {
        return $this->form;
    }
}
