<?php

declare(strict_types=1);

namespace Brain\Common\Form\Handler\Builder;

use Brain\Common\Validator\Enum\CommonValidatorMessageEnum;

use Symfony\Component\Form\Extension\Core\DataMapper\PropertyPathMapper;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormFactory as BaseFormFactory;

/**
 * {@inheritdoc}
 *
 * Extended form factory so that we can inject our custom data accessor in to all forms and child forms.
 */
final class FormFactory extends BaseFormFactory
{
    /** @var mixed[] */
    private $options = [
        'error_bubbling' => false,

        // Never set this at this point, this will prevent objects given to forms as preset data
        // from being modified. Mainly we had an issue with job components not being added to a job
        // using the add() method but instead set directly on the collection.
        // 'by_reference' => false,
        'mapped' => true,

        'extra_fields_message' => CommonValidatorMessageEnum::MESSAGE_FORM_EXTRA,
        'invalid_message' => CommonValidatorMessageEnum::MESSAGE_FORM_INVALID,
    ];

    /**
     * {@inheritdoc}
     *
     * This looks to be the common method that all other factory methods calls. Override this to call its parent
     * and inject the custom form data accessor.
     */
    public function createNamedBuilder($name, $type = FormType::class, $data = null, array $options = [])
    {
        $options = array_merge($options, $this->options);
        $builder = parent::createNamedBuilder($name, $type, $data, $options);

        // Only apply the custom data mapper if its the default.
        // Custom data mappers should be allowed.
        if (!($builder->getDataMapper() instanceof PropertyPathMapper)) {
            return $builder;
        }

        // Override the default data mapper with one that has our custom data accessor.
        // This will silence errors when type hinting is not respected.
        $builder->setDataMapper(
            new PropertyPathMapper(
                new FormDataAccessor()
            )
        );

        return $builder;
    }
}
