<?php

declare(strict_types=1);

namespace Brain\Common\Form\Type\Entity;

use Brain\Common\Database\Database;
use Brain\Common\Form\Helper\FormDataPreNormaliser;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Doctrine\ORM\NonUniqueResultException;
use RuntimeException;

/**
 * {@inheritdoc}
 */
final class EntityLookupType extends AbstractType
{
    public const COLUMN_ID = ['id' => 'publicId'];
    public const COLUMN_ID_ALIAS = ['id' => 'publicId', 'alias' => 'publicAlias'];

    private $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $definitions = $this->createMappingDefinitions($options);

        /**
         * Call the normaliser method.
         *
         * @param FormEvent $event
         */
        $normaliser = function (FormEvent $event) use ($definitions): void {
            $this->handleNormaliseFormData($event, $definitions);
        };

        /**
         * Call the data fetcher method.
         *
         * @param FormEvent $event
         */
        $fetcher = function (FormEvent $event) use ($definitions, $options): void {
            $this->handleDoctrineEntityLookup($event, $definitions, $options);
        };

        $builder->addEventListener(FormEvents::PRE_SUBMIT, $normaliser, 1011);
        $builder->addEventListener(FormEvents::PRE_SUBMIT, $fetcher, 1010);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired(['class', 'columns']);
        $resolver->setDefaults([
            'compound' => false,
            'columns' => self::COLUMN_ID_ALIAS,
        ]);

        $resolver->addAllowedTypes('columns', ['array']);
    }

    /**
     * Convert the column options to lookup definitions.
     *
     * @param mixed[] $options
     *
     * @return EntityLookupDefinition[]
     */
    private function createMappingDefinitions(array $options): array
    {
        $definitions = [];

        $columns = $options['columns'];

        foreach ($columns as $index => $column) {
            $definition = EntityLookupDefinition::create($column);

            if ($index === 'id') {
                $definition->setRegexUUID();
            }

            $definitions[$index] = $definition;
        }

        if (!count($definitions)) {
            throw new RuntimeException('No entity lookup definitions were created.');
        }

        return $definitions;
    }

    /**
     * Handle the normalisation of the form data.
     *
     * @param EntityLookupDefinition[] $definitions
     */
    private function handleNormaliseFormData(FormEvent $event, array $definitions): void
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
    private function handleDoctrineEntityLookup(FormEvent $event, array $definitions, array $options): void
    {
        $data = $event->getData();

        // Initially the data is going to be a series of look up information.
        // This can be considered valid in some validation cases so lets make it null by default.
        $event->setData(null);

        // Fetching the repository through the brain database manager.
        $qb = $this->db->getRepository($options['class'])->createQueryBuilder('e');

        // The expressions will be a series of equality checks against the database.
        // These are build from the entity look up definitions.
        $expressions = [];

        foreach ($definitions as $index => $definition) {
            if ($data[$index] === null) {
                continue;
            }

            $parameter = sprintf(':%s', $definition->getColumn());
            $qb->setParameter($parameter, $data[$index]);

            $expressions[] = $qb->expr()->eq(sprintf('e.%s', $definition->getColumn()), $parameter);
        }

        // If there are no expressions then the data is all null.
        // In this case the constraints should be triggered so return.
        if (count($expressions) === 0) {
            return;
        }

        // Apply the expressions to the query builder.
        // Noting that a single expression should be applied on its own outside of an OR block.
        if (count($expressions) > 1) {
            $qb->where($qb->expr()->orX(...$expressions));
        } else {
            $qb->where($expressions[0]);
        }

        try {
            $entity = $qb->getQuery()->getOneOrNullResult();
        } catch (NonUniqueResultException $exception) {
            $entity = null;
        }

        $event->setData($entity);
    }
}
