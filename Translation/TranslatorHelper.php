<?php

declare(strict_types=1);

namespace Brain\Common\Translation;

/**
 * A series of translation helpers.
 */
final class TranslatorHelper
{
    /**
     * Wrap parameters.
     *
     * @param mixed[] $parameters
     *
     * @return string[]
     */
    public static function wrap(array $parameters): array
    {
        $wrapped = [];

        foreach ($parameters as $key => $value) {
            $key = sprintf('{%s}', $key);
            $wrapped[$key] = $value;
        }

        return $wrapped;
    }
}
