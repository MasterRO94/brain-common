<?php

declare(strict_types=1);

namespace Brain\Common\Request\Filter;

use Symfony\Component\Form\Extension\Core\Type\FormType;

use Lexik\Bundle\FormFilterBundle\Filter\Form\Type\EmbeddedFilterTypeInterface;

/**
 * {@inheritdoc}
 *
 * This is a special abstract filter type for doctrine embeddable's only.
 */
abstract class AbstractEmbeddableFilterType extends AbstractFilterType implements EmbeddedFilterTypeInterface
{
    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return FormType::class;
    }
}
