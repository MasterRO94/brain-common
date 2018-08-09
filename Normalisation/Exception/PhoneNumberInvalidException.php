<?php

declare(strict_types=1);

namespace Brain\Common\Normalisation\Exception;

use Brain\Common\Exception\AbstractBrainRuntimeException;

/**
 * {@inheritdoc}
 */
final class PhoneNumberInvalidException extends AbstractBrainRuntimeException
{
    /**
     * @return PhoneNumberInvalidException
     */
    public static function create(): self
    {
        return new self('The phone number is not valid');
    }
}
