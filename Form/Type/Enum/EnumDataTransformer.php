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

    public function __construct(string $enum)
    {
        $this->enum = $enum;
    }

    /**
     * {@inheritdoc}
     */
    public function transform($value): ?string
    {
        // If the value comes through as null we return null.
        // Null means the value is to be ignored or was not supplied.
        if ($value === null) {
            return null;
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
     */
    public function reverseTransform($value): ?string
    {
        // If the value comes through as null we return null.
        // Null means the value is to be ignored or was not supplied.
        if ($value === null) {
            return null;
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
