<?php

declare(strict_types=1);

namespace Brain\Common\Validator\Helper;

/**
 * A helper for wrapping translation parameters.
 */
final class ValidatorTranslationHelper
{
    public const CONTAINER = '{{%s}}';

    /**
     * Create a template for a translation.
     */
    public static function template(string $value): string
    {
        return sprintf(self::CONTAINER, $value);
    }
}
