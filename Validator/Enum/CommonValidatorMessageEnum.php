<?php

declare(strict_types=1);

namespace Brain\Common\Validator\Enum;

final class CommonValidatorMessageEnum
{
    public const MESSAGE_BLANK = 'value.blank';
    public const MESSAGE_NOT_BLANK = 'value.required';

    public const MESSAGE_REGEX = 'value.regex';

    public const MESSAGE_TYPE_STRING = 'value.type.string';
    public const MESSAGE_TYPE_INTEGER = 'value.type.integer';

    public const MESSAGE_VALID_CHOICE = 'value.choices';

    public const MESSAGE_STRING_LENGTH_MINIMUM = 'value.length.minimum';
    public const MESSAGE_STRING_LENGTH_MAXIMUM = 'value.length.maximum';

    public const MESSAGE_INTEGER_GREATER_THAN = 'value.gt';
    public const MESSAGE_INTEGER_GREATER_THAN_EQUAL = 'value.gte';

    public const MESSAGE_COLLECTION_COUNT_MINIMUM = 'collection.count.minimum';
    public const MESSAGE_COLLECTION_COUNT_MAXIMUM = 'collection.count.maximum';
}
