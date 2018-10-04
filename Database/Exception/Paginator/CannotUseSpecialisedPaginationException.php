<?php

declare(strict_types=1);

namespace Brain\Common\Database\Exception\Paginator;

use Brain\Common\Exception\AbstractBrainRuntimeException;

/**
 * {@inheritdoc}
 */
final class CannotUseSpecialisedPaginationException extends AbstractBrainRuntimeException
{
    /**
     * @return CannotUseSpecialisedPaginationException
     */
    public static function create(): self
    {
        return new self(implode(' ', [
            'You cannot used a specialised paginator that contains a join.',
            'This is down to the fact that joins will duplicate records in the result set.',
            'The reason for using this specialised paginator is to help with query times on large tables.',
        ]));
    }
}
