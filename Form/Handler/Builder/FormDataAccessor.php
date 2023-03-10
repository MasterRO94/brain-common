<?php

declare(strict_types=1);

namespace Brain\Common\Form\Handler\Builder;

use Symfony\Component\PropertyAccess\PropertyAccessor;

use Throwable;
use TypeError;

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
        } catch (TypeError $exception) {
            // this prevents calls to setFooBar(SomeType $fooBar) with null from
            // crashing the app
            return;
        } catch (Throwable $exception) {
            // @todo "delivery time frame" forms rely on this, e.g. @see
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
        } catch (TypeError $exception) {
            // this prevents calls to getFooBar(): SomeType returning null from
            // crashing the app
            return null;
        } catch (Throwable $exception) {
            // @todo this should throw but currently a number of our forms rely
            // on this failing silently, e.g. @see
            // \Brain\Bundle\Job\Form\Type\JobComponentFormType::detectArtworkAndArtifactUsage
            return null;
        }
    }
}
