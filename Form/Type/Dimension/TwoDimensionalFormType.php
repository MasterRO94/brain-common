<?php

declare(strict_types=1);

namespace Brain\Common\Form\Type\Dimension;

use Brain\Common\Dimension\TwoDimensionalInterface;
use Brain\Common\Form\Model\Dimension\TwoDimensionalFormModel;
use Brain\Common\Validator\Factory\CommonValidatorFactory;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * {@inheritdoc}
 */
final class TwoDimensionalFormType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('width', IntegerType::class, [
                'grouping' => false,
                'scale' => 0,
                'constraints' => [
                    CommonValidatorFactory::required(),
                    CommonValidatorFactory::integerGreaterThan(1),
                ],
            ])
            ->add('height', IntegerType::class, [
                'grouping' => false,
                'scale' => 0,
                'constraints' => [
                    CommonValidatorFactory::required(),
                    CommonValidatorFactory::integerGreaterThan(1),
                ],
            ]);

        // A transformer needs to translate in coming instances to the one mentioned
        // in the configuration options for the form.
        $transformer = new CallbackTransformer(
            function ($dimensional) {
                if (!$dimensional instanceof TwoDimensionalInterface) {
                    return new TwoDimensionalFormModel();
                }

                if ($dimensional instanceof TwoDimensionalFormModel) {
                    return $dimensional;
                }

                $model = new TwoDimensionalFormModel();
                $model->width = $dimensional->getWidth();
                $model->height = $dimensional->getHeight();

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
            'data_class' => TwoDimensionalFormModel::class,
            'empty_data' => function () {
                return new TwoDimensionalFormModel();
            },
        ]);
    }
}
