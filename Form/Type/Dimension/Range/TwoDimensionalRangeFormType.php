<?php

declare(strict_types=1);

namespace Brain\Common\Form\Type\Dimension\Range;

use Brain\Common\Form\Model\Dimension\Range\TwoDimensionalRangeFormModel;
use Brain\Common\Form\Type\Dimension\TwoDimensionalFormType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * {@inheritdoc}
 */
final class TwoDimensionalRangeFormType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('minimum', TwoDimensionalFormType::class, [
                'constraints' => [
                    new Assert\Valid(),
                    new Assert\NotBlank([
                        'message' => 'common.form.dimension.two_dimensional_range.minimum.not_blank',
                    ]),
                ],
            ])
            ->add('maximum', TwoDimensionalFormType::class, [
                'constraints' => [
                    new Assert\Valid(),
                    new Assert\NotBlank([
                        'message' => 'common.form.dimension.two_dimensional_range.maximum.not_blank',
                    ]),
                ],
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TwoDimensionalRangeFormModel::class,
            'empty_data' => function () {
                return new TwoDimensionalRangeFormModel();
            },
        ]);
    }
}
