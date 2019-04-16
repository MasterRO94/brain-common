<?php

declare(strict_types=1);

namespace Brain\Common\Request\Filter\Type\Common;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Lexik\Bundle\FormFilterBundle\Filter\Form\Type\DateTimeFilterType;

/**
 * A date range that makes more sense than the lexik version.
 */
final class DateWithinRangeFilterType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('from', DateTimeFilterType::class, $options['from_options']);
        $builder->add('to', DateTimeFilterType::class, $options['to_options']);

        $builder->setAttribute('filter_value_keys', [
            'from' => $options['from_options'],
            'to' => $options['to_options'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $options = [
            'widget' => 'single_text',
        ];

        $resolver
            ->setDefaults([
                'required' => false,
                'from_options' => $options,
                'to_options' => $options,
                'data_extraction_method' => 'value_keys',
            ])
            ->setAllowedValues('data_extraction_method', ['value_keys']);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'filter_date_range';
    }
}
