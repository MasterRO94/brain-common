<?php

namespace Brain\Common\Translation;

/**
 * A series of translation helpers.
 */
final class TranslatorHelper
{
    /**
     * Wrap parameters.
     *
     * @param array $parameters
     *
     * @return array
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
