<?php

declare(strict_types=1);

namespace Brain\Common\Form\Handler\Builder;

use Symfony\Component\PropertyAccess\PropertyAccessor;
use Throwable;

/**
 * {@inheritdoc}
 */
final class FormDataAccessor extends PropertyAccessor
{
    /**
     * {@inheritdoc}
     *
     * Override to catch fatal exceptions when trying to set null.
     */
    public function setValue(&$objectOrArray, $propertyPath, $value)
    {
        try {
            parent::setValue($objectOrArray, $propertyPath, $value);

            // @todo change to \TypeError
        } catch (Throwable $exception) {
            return;
        }
    }

    /**
     * {@inheritdoc}
     *
     * Override to catch fatal exceptions when the return value of a getter is not respecting its type hint. In this
     * case we assume the value is null and return.
     */
    public function getValue($objectOrArray, $propertyPath)
    {
        try {
            return parent::getValue($objectOrArray, $propertyPath);

            // @todo change to \TypeError
        } catch (Throwable $exception) {
            return null;
        }
    }
}
