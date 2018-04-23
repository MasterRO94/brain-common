<?php

namespace Brain\Common\Request\Sort\Enum;

use Brain\Common\Enum\AbstractEnum;

/**
 * {@inheritdoc}
 */
final class SortEnum extends AbstractEnum
{
    const SORT_ASCENDING = 'ASC';
    const SORT_DESCENDING = 'DESC';

    /**
     * {@inheritdoc}
     */
    protected static function getTranslationPrefix(): string
    {
        return 'filter.sort';
    }

    /**
     * {@inheritdoc}
     */
    public static function getValues(): array
    {
        return [
            self::SORT_ASCENDING,
            self::SORT_DESCENDING,
        ];
    }
}
