<?php

declare(strict_types=1);

namespace Brain\Common\Form\Handler\Builder;

use Symfony\Component\PropertyAccess\PropertyAccessor;

/**
 * {@inheritdoc}
 */
final class FormDataAccessor extends PropertyAccessor
{
    /**
     * {@inheritdoc}
     */
    public function setValue(&$objectOrArray, $propertyPath, $value): void
    {
        try {
            parent::setValue($objectOrArray, $propertyPath, $value);

        } catch (\Throwable $exception) {
            // @todo this prevents calls to setFooBar(SomeClass $fooBar) with
            // null from crashing the app, but delivery time frame forms rely
            // on this being here as well, e.g. @see
            // \Brain\Bundle\Delivery\Form\Type\DeliveryServiceDeliveryFinishTimeConfigurationFormType::buildForm
            // \Brain\Bundle\Job\Form\Type\UpdateJobBatchBatchDeliveryFormType::setFormDataInJobBatch
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
