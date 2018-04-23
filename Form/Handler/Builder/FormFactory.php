<?php

namespace Brain\Common\Form\Handler\Builder;

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
    private $options = [
        'error_bubbling' => false,
        'csrf_protection' => false,

        //  Never set this at this point, this will prevent objects given to forms as preset data
        //  from being modified. Mainly we had an issue with job components not being added to a job
        //  using the add() method but instead set directly on the collection.
        //'by_reference' => false,

        'mapped' => true,
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

        //  Override the default data mapper with one that has our custom data accessor.
        //  This will silence errors when type hinting is not respected.
        $builder->setDataMapper(
            new PropertyPathMapper(
                new FormDataAccessor()
            )
        );

        return $builder;
    }
}
