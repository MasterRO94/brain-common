<?php

declare(strict_types=1);

namespace Brain\Common\Form\Type\Entity;

use Brain\Common\Form\Helper\FormDataPreNormaliser;

use Symfony\Component\Form\FormEvent;

final class EntityLookupHelper
{
    /**
     * Handle the normalisation of the form data.
     *
     * @param EntityLookupDefinition[] $definitions
     */
    public static function normalise(FormEvent $event, array $definitions): void
    {
        $data = $event->getData();
        $data = FormDataPreNormaliser::normaliseForMappedColumns($data, $definitions);

        $event->setData($data);
    }

    /**
     * Handle the lookup and basic validation of the specified entity.
     *
     * @param EntityLookupDefinition[] $definitions
     * @param mixed[] $options
     */
    public static function resolve(FormEvent $event, array $definitions, array $options): void
    {
        $data = $event->getData();
        $form = $event->getForm();

        // Initially the data is going to be a series of look up information.
        // This can be considered valid in some validation cases so lets make it null by default.
        $event->setData(null);

        $class = $options['class'];

        /** @var EntityLookupDoctrineResolver $resolver */
        $resolver = $form->getConfig()->getOption('resolver');
        $resolved = $resolver->resolve($class, $data, $definitions);

        $event->setData($resolved);
    }
}
