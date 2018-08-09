<?php

declare(strict_types=1);

namespace Brain\Common\Form\Exception;

use Brain\Common\Exception\AbstractBrainRuntimeException;

/**
 * {@inheritdoc}
 */
final class FormHandlerException extends AbstractBrainRuntimeException
{
    /**
     * @return FormHandlerException
     */
    public static function createForInvalidPaginatorAdapter(): self
    {
        return new self(implode(' ', [
            'The pagination adapter used to create the paginator is invalid.',
            'It must be an instance of "PaginatorQueryBuilderAdapter" so we can manage its query.',
        ]));
    }
}
