<?php

declare(strict_types=1);

namespace Brain\Common\Validator\Enum;

use Brain\Common\Validator\Constraint\Remote\RemoteConstraint;

/**
 * Common validation messages.
 */
final class CommonValidatorMessageEnum
{
    public const MESSAGE_FORM_EXTRA = 'form.extra';
    public const MESSAGE_FORM_INVALID = 'form.invalid';

    /**
     * Unknown is used for validators that do not know how to respond.
     * This should not be used directly but is used when configuration is wrong.
     *
     * @see RemoteConstraint
     */
    public const MESSAGE_UNKNOWN = 'value.unknown';

    /**
     * Blank indicates that a value is not expected.
     * Usually used for scenarios where something gets disabled.
     */
    public const MESSAGE_BLANK = 'value.blank';

    /**
     * Valid is used when the value given is not valid.
     * This can be used by custom validators where a value was given but was resolved as invalid.
     */
    public const MESSAGE_VALID = 'value.valid';

    /**
     * Required is used when the value is not provided, but is required.
     */
    public const MESSAGE_REQUIRED = 'value.required';

    public const MESSAGE_REGEX = 'value.regex';

    public const MESSAGE_TYPE_STRING = 'value.type.string';
    public const MESSAGE_TYPE_INTEGER = 'value.type.integer';

    public const MESSAGE_STRING_URL = 'value.url';
    public const MESSAGE_STRING_EMAIL = 'value.email';

    public const MESSAGE_STRING_LENGTH_MINIMUM = 'value.length.minimum';
    public const MESSAGE_STRING_LENGTH_MAXIMUM = 'value.length.maximum';

    public const MESSAGE_VALID_CHOICE = 'value.choices';

    public const MESSAGE_INTEGER_GREATER_THAN = 'value.gt';
    public const MESSAGE_INTEGER_GREATER_THAN_EQUAL = 'value.gte';

    public const MESSAGE_COLLECTION_COUNT_MINIMUM = 'collection.count.minimum';
    public const MESSAGE_COLLECTION_COUNT_MAXIMUM = 'collection.count.maximum';
}
