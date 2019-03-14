<?php

declare(strict_types=1);

namespace Brain\Common\Form\Type\Enum;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * A form type that integrates with the enum class.
 *
 * Note; this form does not handle validation.
 * Make sure of the choice validator and the enum itself.
 */
final class EnumType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addModelTransformer(new EnumDataTransformer($options['enum']));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired('enum');
        $resolver->setAllowedTypes('enum', ['string']);
    }

    /**
     * {@inheritdoc}
     */
    public function getParent(): string
    {
        return TextType::class;
    }
}
