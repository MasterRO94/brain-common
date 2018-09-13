<?php

declare(strict_types=1);

namespace Brain\Common\Form\Type\Dimension\Range;

use Brain\Common\Dimension\Range\TwoDimensionalRangeInterface;
use Brain\Common\Form\Model\Dimension\Range\TwoDimensionalRangeFormModel;
use Brain\Common\Form\Type\Dimension\TwoDimensionalFormType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
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

        // A transformer needs to translate in coming instances to the one mentioned
        // in the configuration options for the form.
        $transformer = new CallbackTransformer(
            function ($range) {
                if (!$range instanceof TwoDimensionalRangeInterface) {
                    return new TwoDimensionalRangeFormModel();
                }

                if ($range instanceof TwoDimensionalRangeFormModel) {
                    return $range;
                }

                $model = new TwoDimensionalRangeFormModel();
                $model->minimum = $range->getMinimumDimension();
                $model->maximum = $range->getMaximumDimension();

                return $model;
            },
            function ($ignore) {
                return $ignore;
            }
        );

        $builder->addModelTransformer($transformer);
        $builder->addViewTransformer($transformer);
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
