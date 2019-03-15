<?php

declare(strict_types=1);

namespace Brain\Common\Validator\Factory;

use Brain\Common\Enum\AbstractEnum;
use Brain\Common\Validator\Constraint\EnumChoice;
use Brain\Common\Validator\Enum\CommonValidatorMessageEnum;

use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\Count;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\Valid;

/**
 * Static factory for creating common validators for forms.
 */
final class CommonValidatorFactory
{
    /**
     * Make the validator propagate to children.
     */
    public static function propagate(): Valid
    {
        return new Valid();
    }

    /**
     * Mark the field required.
     */
    public static function required(): NotNull
    {
        return new NotNull([
            'message' => CommonValidatorMessageEnum::MESSAGE_NOT_BLANK,
        ]);
    }

    /**
     * Type string.
     */
    public static function string(): Type
    {
        return new Type([
            'type' => 'string',
            'message' => CommonValidatorMessageEnum::MESSAGE_TYPE_STRING,
        ]);
    }

    /**
     * String length.
     */
    public static function stringLength(int $minimum, ?int $maximum): Length
    {
        return new Length([
            'min' => $minimum,
            'max' => $maximum,
            'minMessage' => CommonValidatorMessageEnum::MESSAGE_STRING_LENGTH_MINIMUM,
            'maxMessage' => CommonValidatorMessageEnum::MESSAGE_STRING_LENGTH_MAXIMUM,
        ]);
    }

    /**
     * Type integer.
     */
    public static function integer(): Type
    {
        return new Type([
            'type' => 'integer',
            'message' => CommonValidatorMessageEnum::MESSAGE_TYPE_INTEGER,
        ]);
    }

    /**
     * Integer greater than to value.
     */
    public static function integerGreaterThan(int $value): GreaterThan
    {
        return new GreaterThan([
            'value' => $value,
            'message' => CommonValidatorMessageEnum::MESSAGE_INTEGER_GREATER_THAN,
        ]);
    }

    /**
     * Integer greater than or equal to value.
     */
    public static function integerGreaterThanOrEqual(int $value): GreaterThanOrEqual
    {
        return new GreaterThanOrEqual([
            'value' => $value,
            'message' => CommonValidatorMessageEnum::MESSAGE_INTEGER_GREATER_THAN_EQUAL,
        ]);
    }

    /**
     * Collection count.
     */
    public static function collectionCount(int $minimum, ?int $maximum): Count
    {
        return new Count([
            'min' => $minimum,
            'max' => $maximum,
            'minMessage' => CommonValidatorMessageEnum::MESSAGE_COLLECTION_COUNT_MINIMUM,
            'maxMessage' => CommonValidatorMessageEnum::MESSAGE_COLLECTION_COUNT_MAXIMUM,
        ]);
    }

    /**
     * Choice.
     *
     * @param string[] $choices
     */
    public static function choice(array $choices): Choice
    {
        return new Choice([
            'choices' => $choices,
            'message' => CommonValidatorMessageEnum::MESSAGE_VALID_CHOICE,
        ]);
    }

    /**
     * Choice from AbstractEnum.
     *
     * @see AbstractEnum
     */
    public static function enum(string $enum): EnumChoice
    {
        return new EnumChoice([
            'enum' => $enum,
        ]);
    }
}
