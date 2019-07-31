<?php

declare(strict_types=1);

namespace Brain\Common\Form\Type\Api\Scalar;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Pre-configured api integer type.
 */
final class ApiIntegerType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'grouping' => false,
            'scale' => 0,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getParent(): string
    {
        return IntegerType::class;
    }
}
