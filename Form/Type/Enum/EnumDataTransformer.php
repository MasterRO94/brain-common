<?php

declare(strict_types=1);

namespace Brain\Common\Form\Type\Enum;

use Brain\Common\Enum\AbstractEnum;
use Brain\Common\Enum\Exception\TranslationInvalidForEnumException;
use Brain\Common\Enum\Exception\ValueInvalidForEnumException;

use Symfony\Component\Form\DataTransformerInterface;

/**
 * A data transformer to convert canonical enum values to internal values.
 */
final class EnumDataTransformer implements
    DataTransformerInterface
{
    private $enum;
    private $default;

    /**
     * @param mixed $default
     */
    public function __construct(string $enum, $default = null)
    {
        $this->enum = $enum;
        $this->default = $default;
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

        /** @var AbstractEnum $enum */
        $enum = $this->enum;

        try {
            return $enum::translate($value);
        } catch (ValueInvalidForEnumException $exception) {
            return '';
        }
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

        try {
            return $enum::value($value);
        } catch (TranslationInvalidForEnumException $exception) {
            return '';
        }
    }
}
