<?php

declare(strict_types=1);

namespace Brain\Common\Normalisation\Validator;

/**
 * A postal code validator.
 *
 * As the library I wanted to implement has some goofy constraints on dependencies here is a version of it.
 *
 * @see https://packagist.org/packages/detain/zip-zapper
 */
final class PostCodeValidator
{
    /**
     * Check the postal code is valid for the country iso.
     *
     * If the country code is not supported then this will return false.
     * But this is not necessarily meaning the postcode is invalid just there is not validation for it.
     */
    public function isValid(string $value, string $country): bool
    {
        $value = $this->standardise($value);

        if (self::hasCountryFormat($country) === false) {
            return false;
        }

        $formats = PostCodeValidatorFormat::getFormat($country);

        if (count($formats) === 0) {
            return true;
        }

        foreach ($formats as $format) {
            $regex = PostCodeValidatorFormat::convertFormatToRegex($format);

            if (preg_match($regex, $value) === 1) {
                return true;
            }
        }

        return false;
    }

    /**
     * Attempt to standardise the value given.
     */
    public function standardise(string $value): string
    {
        $value = strtoupper($value);

        $value = str_replace(' ', '', $value);

        return $value;
    }

    /**
     * Check the country iso is supported.
     */
    public function hasCountryFormat(string $country): bool
    {
        return PostCodeValidatorFormat::hasFormat($country);
    }
}
