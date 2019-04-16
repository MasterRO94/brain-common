<?php

declare(strict_types=1);

namespace Brain\Common\Form\Type\Date;

use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * {@inheritdoc}
 */
final class ApiDateTimeType extends DateTimeType
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults([
            'widget' => 'single_text',
        ]);
    }
}
