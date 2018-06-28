<?php

namespace Brain\Common\Normalisation\Exception;

use Brain\Common\Exception\AbstractBrainRuntimeException;

/**
 * {@inheritdoc}
 */
final class PostalCodeInvalidException extends AbstractBrainRuntimeException
{
    /**
     * @return PostalCodeInvalidException
     */
    public static function create(): self
    {
        return new self('The postal code is not valid');
    }
}
