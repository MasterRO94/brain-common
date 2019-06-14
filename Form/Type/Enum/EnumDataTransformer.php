<?php

declare(strict_types=1);

namespace Brain\Common\Form\Type\Enum;

use Brain\Common\Enum\AbstractEnum;
use Brain\Common\Enum\Exception\TranslationInvalidForEnumException;

use Symfony\Component\Form\DataTransformerInterface;

/**
 * A data transformer to convert canonical enum values to internal values.
 */
final class EnumDataTransformer implements
    DataTransformerInterface
{
    /** @var string */
    private $enum;

    /** @var string|null */
    private $default;

    /** @var bool */
    private $legacy;

    public function __construct(string $enum, ?string $default, bool $legacy)
    {
        $this->enum = $enum;
        $this->default = $default;
        $this->legacy = $legacy;
    }

    /**
     * {@inheritdoc}
     *
     * Model data to form data.
     */
    public function transform($value): ?string
    {
        // If the value comes through as null we return the default.
        // In most cases the default will be null.
        if ($value === null) {
            return $this->default;
        }

        // If the value is not null and is not a string then its invalid.
        // To simulate this we give it an empty string value.
        if (is_string($value) === false) {
            return '';
        }

        return $value;
    }

    /**
     * {@inheritdoc}
     *
     * Form data to model data.
     */
    public function reverseTransform($value): ?string
    {
        // If the value comes through as null we return the default.
        // In most cases the default will be null.
        if ($value === null) {
            return $this->default;
        }

        // If the value is not null and is not a string then its invalid.
        // To simulate this we give it an empty string value.
        if (is_string($value) === false) {
            return '';
        }

        /** @var AbstractEnum $enum */
        $enum = $this->enum;

        // Legacy mode attempt to translate to a value.
        if ($this->legacy === true) {
            try {
                $value = $enum::valueFromTranslation($value);
            } catch (TranslationInvalidForEnumException $exception) {
                // Ignore.
            }
        }

        if ($enum::has($value)) {
            return $value;
        }

        return '';
    }
}
