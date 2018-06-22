<?php

namespace Brain\Common\Form\Type\Normalisation;

use Brain\Common\Normalisation\PhoneNumber;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * A phone number standardisation field.
 *
 * The phone number input is validated against the `country_iso` (that can be resolved using `country_iso_resolver`).
 * * If the phone number is valid then the number is formatted in an international format, e.g +447809123456
 * * If the phone number is invalid then its resolved as null.
 *
 * Use `NotNull` or `NotBlank` assertions to validate the field has a valid value.
 */
final class PhoneNumberType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        /**
         * A value normaliser for phone number types.
         *
         * @param FormEvent $event
         */
        $normaliser = function (FormEvent $event) use ($options): void {
            $form = $event->getForm();
            $data = $event->getData();

            if (!is_string($data)) {
                $event->setData(null);

                return;
            }

            //  Attempt to resolve the country ISO code.
            if (is_callable($options['country_iso_resolver'])) {
                $resolver = $options['country_iso_resolver'];

                $iso = $resolver($form->getParent());
            } else {
                $iso = $options['country_iso'];
            }

            //  If the country ISO is null then the phone is null.
            //  A phone number cannot be valid without one.
            //  Manually specify in the form options or fix the resolver.
            if ($iso === null) {
                $event->setData(null);

                return;
            }

            $instance = new PhoneNumber($data, $iso);

            if ($instance->isValid() === false) {
                $event->setData(null);

                return;
            }

            $event->setData($instance->getStandardisedNumber());
        };

        $builder->addEventListener(FormEvents::PRE_SUBMIT, $normaliser, -100);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults([
            'country_iso' => null,
            'country_iso_resolver' => null,
        ]);

        $resolver->setAllowedTypes('country_iso', ['string', 'null']);
        $resolver->setAllowedTypes('country_iso_resolver', ['callable', 'null']);
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return TextType::class;
    }
}
