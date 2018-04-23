<?php

namespace Brain\Common\Form\Type\Entity;

use Brain\Common\Database\Database;
use Brain\Common\Form\Helper\FormDataPreNormaliser;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Doctrine\ORM\NonUniqueResultException;

/**
 * {@inheritdoc}
 */
final class EntityLookupType extends AbstractType
{
    const COLUMN_ID = ['id' => 'publicId'];
    const COLUMN_ID_ALIAS = ['id' => 'publicId', 'alias' => 'publicAlias'];

    private $db;

    /**
     * Constructor.
     *
     * @param Database $db
     */
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
        $normaliser = function (FormEvent $event) use ($definitions) {
            $this->handleNormaliseFormData($event, $definitions);
        };

        /**
         * Call the data fetcher method.
         *
         * @param FormEvent $event
         */
        $fetcher = function (FormEvent $event) use ($definitions, $options) {
            $this->handleDoctrineEntityLookup($event, $definitions, $options);
        };

        $builder->addEventListener(FormEvents::PRE_SUBMIT, $normaliser);
        $builder->addEventListener(FormEvents::PRE_SUBMIT, $fetcher);
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
     * @param array $options
     *
     * @return array
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
            throw new \RuntimeException('No entity lookup definitions were created.');
        }

        return $definitions;
    }

    /**
     * Handle the normalisation of the form data.
     *
     * @param FormEvent $event
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
     * @param FormEvent $event
     * @param EntityLookupDefinition[] $definitions
     * @param array $options
     */
    private function handleDoctrineEntityLookup(FormEvent $event, array $definitions, array $options): void
    {
        $data = $event->getData();

        //  Fetching the repository through the brain database manager.
        $qb = $this->db->getRepository($options['class'])->createQueryBuilder('e');

        //  The expressions will be a series of equality checks against the database.
        //  These are build from the entity look up definitions.
        $expressions = [];

        foreach ($definitions as $index => $definition) {
            if (is_null($data[$index])) {
                continue;
            }

            $parameter = sprintf(':%s', $definition->getColumn());
            $qb->setParameter($parameter, $data[$index]);

            $expressions[] = $qb->expr()->eq(sprintf('e.%s', $definition->getColumn()), $parameter);
        }

        //  If there are no expressions then the data is all null.
        //  In this case the constraints should be triggered so return.
        if (count($expressions) === 0) {
            return;
        }

        //  Apply the expressions to the query builder.
        //  Noting that a single expression should be applied on its own outside of an OR block.
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
