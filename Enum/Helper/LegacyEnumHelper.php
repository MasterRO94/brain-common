<?php

declare(strict_types=1);

namespace Brain\Common\Enum\Helper;

use Brain\Common\Enum\EnumInterface;
use Brain\Common\Enum\EnumTranslationInterface;
use Brain\Common\Enum\Exception\TranslationInvalidForEnumException;
use Brain\Common\Enum\Exception\ValueInvalidForEnumException;

final class LegacyEnumHelper
{
    /**
     * @return string|int
     *
     * @throws ValueInvalidForEnumException
     * @throws TranslationInvalidForEnumException
     */
    public static function getValueFromTranslation(string $enum, string $translation)
    {
        /** @var EnumInterface&EnumTranslationInterface $class */
        $class = $enum;

        /** @var string[]|int[] $translations */
        $translations = [];

        foreach ($class::all() as $value) {
            $translated = $class::translate($value);

            $translations[$translated] = $value;
        }

        if (isset($translations[$translation]) === false) {
            /** @var string[] $keys */
            $keys = array_keys($translations);

            throw TranslationInvalidForEnumException::create($enum, $translation, $keys);
        }

        return $translations[$translation];
    }
}
