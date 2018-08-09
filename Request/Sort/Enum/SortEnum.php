<?php

declare(strict_types=1);

namespace Brain\Common\Request\Sort\Enum;

use Brain\Common\Enum\AbstractEnum;

/**
 * {@inheritdoc}
 */
final class SortEnum extends AbstractEnum
{
    public const SORT_ASCENDING = 'ASC';
    public const SORT_DESCENDING = 'DESC';

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
