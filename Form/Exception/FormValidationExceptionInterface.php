<?php

declare(strict_types=1);

namespace Brain\Common\Form\Exception;

use Symfony\Component\Form\FormInterface;

interface FormValidationExceptionInterface
{
    /**
     * Return the form.
     */
    public function getForm(): FormInterface;
}
