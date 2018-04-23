<?php

namespace Brain\Common\Form\Exception;

use Symfony\Component\Form\FormInterface;

interface FormValidationExceptionInterface
{
    /**
     * Return the form.
     *
     * @return FormInterface
     */
    public function getForm(): FormInterface;
}
