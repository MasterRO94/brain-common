<?php

declare(strict_types=1);

namespace Brain\Common\Form\Type\Entity;

use Brain\Common\Database\DatabaseInterface;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * {@inheritdoc}
 */
final class EntityLookupType extends AbstractType
{
    /** @var DatabaseInterface */
    private $database;

    public function __construct(DatabaseInterface $database)
    {
        $this->database = $database;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        /** @var EntityLookupDefinition[] $definitions */
        $definitions = $options['columns'];

        /**
         * Attempt to resolve the entity lookup.
         */
        $listener = static function (FormEvent $event) use ($definitions, $options): void {
            EntityLookupHelper::normalise($event, $definitions);
            EntityLookupHelper::resolve($event, $definitions, $options);
        };

        $builder->addEventListener(FormEvents::PRE_SUBMIT, $listener, 1500);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setRequired([
            'class',
            'columns',
            'resolver',
        ]);

        $resolver->addAllowedTypes('columns', ['array']);
        $resolver->addAllowedTypes('resolver', ['object']);

        $resolver->setDefaults([
            'compound' => false,
            'resolver' => new EntityLookupDoctrineResolver($this->database),
        ]);
    }
}
