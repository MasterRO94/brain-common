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
    public function transform($value)
    {
        if (is_string($value) === false) {
            return null;
        }

        /** @var AbstractEnum $enum */
        $enum = $this->enum;

        try {
            return $enum::translate($value);
        } catch (ValueInvalidForEnumException $exception) {
            return null;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function reverseTransform($value)
    {
        if (is_string($value) === false) {
            return null;
        }

        /** @var AbstractEnum $enum */
        $enum = $this->enum;

        try {
            return $enum::value($value);
        } catch (TranslationInvalidForEnumException $exception) {
            return null;
        }
    }
}
