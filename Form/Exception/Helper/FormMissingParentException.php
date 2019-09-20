<?php

declare(strict_types=1);

namespace Brain\Common\Form\Exception\Helper;

use Exception;

final class FormMissingParentException extends Exception
{
    /**
     * @return FormMissingParentException
     */
    public static function create(): self
    {
        return new self();
    }

    public function __construct()
    {
        $message = 'This form has no parent!';

        parent::__construct($message);
    }
}
