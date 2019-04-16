<?php

declare(strict_types=1);

namespace Brain\Common\Request\Filter\Exception;

use Brain\Common\Exception\AbstractBrainRuntimeException;
use Brain\Common\Form\Exception\FormValidationExceptionInterface;

use Symfony\Component\Form\FormInterface;

/**
 * A filter form validation exception.
 */
final class FilterFormValidationException extends AbstractBrainRuntimeException implements
    FormValidationExceptionInterface
{
    /** @var FormInterface */
    private $form;

    public function __construct(FormInterface $form)
    {
        parent::__construct('The filter form did not pass validation', null);

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
