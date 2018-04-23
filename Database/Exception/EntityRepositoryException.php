<?php

namespace Brain\Common\Database\Exception;

use Brain\Common\Exception\AbstractBrainRuntimeException;

/**
 * {@inheritdoc}
 */
final class EntityRepositoryException extends AbstractBrainRuntimeException
{
    /**
     * @return EntityRepositoryException
     */
    public static function createForMissingPaginationFactory(): self
    {
        return new self(implode(' ', [
            'The repository is missing the pagination factory and therefore cannot provide paginated collections.',
            'Make sure this repository is constructed through the custom database service and not doctrine.',
        ]));
    }

    /**
     * @return EntityRepositoryException
     */
    public static function createForMissingAuthenticationStorage(): self
    {
        return new self(implode(' ', [
            'The repository is missing the authentication storage and therefore cannot provide user details.',
            'Make sure this repository is constructed through the custom database service and not doctrine.',
        ]));
    }
}
