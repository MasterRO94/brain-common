<?php

declare(strict_types=1);

namespace Brain\Common\Form\Type\Enum;

use Brain\Common\Validator\Factory\CommonValidatorFactory;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * A form type that integrates with the enum class.
 *
 * The value expected is the translated string not the internal value.
 * This is the value with the enum prefix.
 * The value in the data will be the internal value (it will have been translated).
 *
 * Note; this form does not handle validation, when a match is not valid it returns an empty string.
 * Make use of the EnumChoice validator to make sure the choice is one of the choices in the enum.
 * Make use of the NotBlank validator to make this form type required.
 *
 * In cases where the value is not provided to the form the value is null.
 * In cases where the value is provided but not valid the value is empty string.
 * In cases where the value is valid its translated to its internal value.
 *
 * @see CommonValidatorFactory::enum()
 * @see CommonValidatorFactory::required()
 */
final class EnumType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addModelTransformer(
            new EnumDataTransformer(
                $options['enum'],
                $options['default']
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired('enum');
        $resolver->setAllowedTypes('enum', ['string']);

        $resolver->setDefault('default', null);
        $resolver->setAllowedTypes('default', ['string', 'null']);
    }

    /**
     * {@inheritdoc}
     */
    public function getParent(): string
    {
        return TextType::class;
    }
}
