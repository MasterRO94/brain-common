<?php

namespace Brain\Common\Normalisation\Exception\Validator;

use Brain\Common\Exception\AbstractBrainRuntimeException;

/**
 * {@inheritdoc}
 */
final class PostCodeFormatNotFoundException extends AbstractBrainRuntimeException
{
    /**
     * @return PostCodeFormatNotFoundException
     */
    public static function create(): self
    {
        return new self('The postal code format is not found');
    }
}
