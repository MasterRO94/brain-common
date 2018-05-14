<?php

namespace Brain\Common\Request\Filter;

use Brain\Common\Request\Filter\Helper\EmbedFilterHelper;
use Brain\Common\Request\Filter\Helper\FilterDatabaseHelper;
use Brain\Common\Request\Filter\Helper\FilterValueHelper;
use Brain\Common\Request\Filter\Type\Common\DateWithinRangeFilterType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

use Lexik\Bundle\FormFilterBundle\Filter\Doctrine\ORMQuery;
use Lexik\Bundle\FormFilterBundle\Filter\FilterOperands;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type\SharedableFilterType;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type\TextFilterType;

/**
 * {@inheritdoc}
 */
abstract class AbstractFilterType extends AbstractType
{
    /** @var FormBuilderInterface */
    private $builder;

    /**
     * Build the filter form.
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    abstract public function filter(FormBuilderInterface $builder, array $options): void;

    /**
     * {@inheritdoc}
     */
    final public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->builder = $builder;

        $this->filter($builder, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'csrf_protection' => false,
            'validation_groups' => ['filtering'],
            'method' => Request::METHOD_GET,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return SharedableFilterType::class;
    }

    /**
     * Add an embedded child form.
     *
     * @param string $field
     * @param string $column
     * @param string $filter
     * @param bool $nullable
     */
    protected function embed(string $field, string $column, string $filter, bool $nullable): void
    {
        $listener = function (FormEvent $event) use ($field, $column, $filter, $nullable) {
            /** @var array|string $data */
            $data = $event->getData();
            $form = $event->getForm();

            if (!is_array($data)) {
                return;
            }

            if (!isset($data[$field])) {
                return;
            }

            $value = $data[$field];

            //  Empty strings can be ignored.
            //  This should cause the form handler to throw a violation.
            if ($value === '') {
                return;
            }

            if (is_string($value) && in_array(strtolower($value), ['null', 'false'])) {
                //  Should the child filter not be nullable we can return.
                //  This should cause the form handler to throw a violation.
                if (!$nullable) {
                    return;
                }

                //  This form is simply going to run the query builder.
                $form->add($field, TextFilterType::class, [
                    'apply_filter' => function (ORMQuery $filter, string $field, array $values) use ($column) {
                        $alias = FilterDatabaseHelper::getAliasFromColumn($field);
                        $field = FilterDatabaseHelper::generateFieldName($alias, $column);

                        $qb = $filter->getQueryBuilder();
                        $qb->andWhere($qb->expr()->isNull($field));
                    },
                ]);

                return;
            }

            if (is_string($value) && in_array(strtolower($value), ['not-null', 'true'])) {
                //  Should the child filter not be nullable we can return.
                //  This should cause the form handler to throw a violation.
                if (!$nullable) {
                    return;
                }

                //  This form is simply going to run the query builder.
                $form->add($field, TextFilterType::class, [
                    'apply_filter' => function (ORMQuery $filter, string $field, array $values) use ($column) {
                        $alias = FilterDatabaseHelper::getAliasFromColumn($field);
                        $field = FilterDatabaseHelper::generateFieldName($alias, $column);

                        $qb = $filter->getQueryBuilder();
                        $qb->andWhere($qb->expr()->isNotNull($field));
                    },
                ]);

                return;
            }

            $form->add($field, $filter, [
                'add_shared' => EmbedFilterHelper::embed($field, $column),
            ]);
        };

        $this->builder->addEventListener(FormEvents::PRE_SUBMIT, $listener);
    }

    /**
     * Add the standard id filter.
     */
    protected function addIdentityFilter(): void
    {
        $this->builder->add('id', TextFilterType::class, [
            'condition_pattern' => FilterOperands::STRING_EQUALS,
            'apply_filter' => function (ORMQuery $filter, string $field, array $values) {
                $value = $values['value'];

                if (!FilterValueHelper::isValidSearchTerm($value)) {
                    return;
                }

                $alias = FilterDatabaseHelper::getAliasFromColumn($field);
                $field = FilterDatabaseHelper::generateFieldName($alias, 'publicId');
                $parameter = FilterDatabaseHelper::generateParameterName($field);

                $qb = $filter->getQueryBuilder();
                $qb->andWhere($qb->expr()->eq($field, sprintf(':%s', $parameter)));
                $qb->setParameter($parameter, $value);
            },
            'constraints' => [
                new Assert\Type([
                    'type' => 'string',
                    'message' => 'filter.id.type',
                    'groups' => ['filtering'],
                ]),
                new Assert\Length([
                    'min' => 5,
                    'minMessage' => 'filter.id.length_min',
                    'groups' => ['filtering'],
                ]),
            ],
        ]);
    }

    /**
     * Add the standard alias filter.
     */
    protected function addAliasFilter(): void
    {
        $this->builder->add('alias', TextFilterType::class, [
            'condition_pattern' => FilterOperands::STRING_EQUALS,
            'apply_filter' => function (ORMQuery $filter, string $field, array $values) {
                $value = $values['value'] ?? '';

                if (!FilterValueHelper::isValidSearchTerm($value)) {
                    return;
                }

                $alias = FilterDatabaseHelper::getAliasFromColumn($field);
                $field = FilterDatabaseHelper::generateFieldName($alias, 'publicAlias');
                $parameter = FilterDatabaseHelper::generateParameterName($field);

                $qb = $filter->getQueryBuilder();
                $qb->andWhere($qb->expr()->eq($field, sprintf(':%s', $parameter)));
                $qb->setParameter($parameter, $value);
            },
            'constraints' => [
                new Assert\Type([
                    'type' => 'string',
                    'message' => 'filter.alias.type',
                    'groups' => ['filtering'],
                ]),
                new Assert\Length([
                    'min' => 5,
                    'minMessage' => 'filter.alias.length_min',
                    'groups' => ['filtering'],
                ]),
            ],
        ]);
    }

    /**
     * Add a multiple choice filter.
     *
     * @param string $field
     * @param string|null $column
     * @param array $choices
     */
    protected function addMultipleChoiceFilter(string $field, ?string $column, array $choices): void
    {
        $column = $column ?: $field;

        $this->builder->add($field, TextFilterType::class, [
            'apply_filter' => function (ORMQuery $filter, string $field, array $values) use ($column, $choices) {
                $value = $values['value'] ?? '';

                //  The value can sometimes come through as a string.
                //  In this case we just return early.
                if (is_null($value) || ($value === '')) {
                    return;
                }

                /** @var string[] $givenChoices */
                $givenChoices = $value;
                $mappedChoices = array_flip($choices);

                //  Make sure each of the choices given is legit.
                //  If one isn't then we can remove it from the filter.
                foreach ($givenChoices as $index => $choice) {
                    if (!FilterValueHelper::isValidInput($choice)) {
                        unset($givenChoices[$index]);
                    }

                    if (!isset($mappedChoices[$choice])) {
                        unset($givenChoices[$index]);
                    }
                }

                if (count($givenChoices) === 0) {
                    return;
                }

                $values = [];

                //  Get the values in the database.
                foreach ($givenChoices as $choice) {
                    $values[] = $mappedChoices[$choice];
                }

                $alias = FilterDatabaseHelper::getAliasFromColumn($field);
                $field = FilterDatabaseHelper::generateFieldName($alias, $column);
                $parameter = FilterDatabaseHelper::generateParameterName($field);

                $qb = $filter->getQueryBuilder();
                $qb->andWhere($qb->expr()->in($field, sprintf(':%s', $parameter)));
                $qb->setParameter($parameter, $values);
            },
            'constraints' => [
                new Assert\Count([
                    'min' => 1,
                    'minMessage' => sprintf('filter.%s.choice.count_min', $field),
                    'groups' => ['filtering'],
                ]),
                new Assert\Choice([
                    'multiple' => true,
                    'choices' => array_values($choices),
                    'message' => sprintf('filter.%s.choice.choice_multiple', $field),
                    'multipleMessage' => sprintf('filter.%s.choice.choice_multiple', $field),
                    'groups' => ['filtering'],
                ]),
            ],
        ]);

        //  Repair the data that is being sent.
        //  In the cases where an array is not given we wrap the data in an array.
        $this->builder->get($field)->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {
            /** @var array|string $data */
            $data = $event->getData();

            //  Null must return here, sending anything but null will trigger validation.
            //  Even if null is wrapped in an array.
            if (is_null($data)) {
                return;
            }

            //  An array of data is what we expect so return.
            if (is_array($data)) {
                return;
            }

            //  Otherwise wrap the data given in an array.
            //  This simulates a multiple entry.
            $event->setData([$data]);
        });
    }

    /**
     * Add a date filter.
     *
     * @param string $field
     * @param string|string $column
     */
    protected function addDateFilter(string $field, string $column = null): void
    {
        $column = $column ?: $field;

        $this->builder->add($field, DateWithinRangeFilterType::class, [
            'apply_filter' => function (ORMQuery $filter, string $field, array $values) use ($column) {
                $value = $values['value'];

                $alias = FilterDatabaseHelper::getAliasFromColumn($field);
                $field = FilterDatabaseHelper::generateFieldName($alias, $column);

                $qb = $filter->getQueryBuilder();

                /** @var \DateTime $from */
                $from = $value['from'][0];

                /** @var \DateTime $to */
                $to = $value['to'][0];

                //  When we have both an to and from date we have a few cases to consider.
                if (($from instanceof \DateTimeInterface) && ($to instanceof \DateTimeInterface)) {

                    //  First case is where the dates match exactly.
                    //  In this case we are looking for an entire day.
                    //  It seems very unlikely that a search for a specific second will be performed.
                    if ($from == $to) {
                        $parameter = FilterDatabaseHelper::generateParameterName($field);

                        $qb->andWhere(
                            $qb->expr()->eq(
                                sprintf('DATE(%s)', $field),
                                sprintf(':%s', $parameter)
                            )
                        );

                        $qb->setParameter($parameter, $to->format('Y-m-d'));

                        return;
                    }

                    //  Second case is a simple between dates search.
                    //  For this we can use the built in SQL BETWEEN.

                    $parameterFrom = FilterDatabaseHelper::generateParameterName($field);
                    $parameterTo = FilterDatabaseHelper::generateParameterName($field);

                    $qb->andWhere(
                        $qb->expr()->between(
                            $field,
                            sprintf(':%s', $parameterFrom),
                            sprintf(':%s', $parameterTo)
                        )
                    );

                    $qb->setParameter($parameterFrom, $from);
                    $qb->setParameter($parameterTo, $to);

                    return;
                }

                //  These are cases where only one side is available.

                //  The "from" date means we want to find greater than the date.
                //  Where the time is not given the the time is set to midnight (the morning).
                if ($from instanceof \DateTimeInterface) {
                    $parameter = FilterDatabaseHelper::generateParameterName($field);

                    $qb->andWhere($qb->expr()->gte($field, sprintf(':%s', $parameter)));
                    $qb->setParameter($parameter, $from);
                }

                //  The "to" date means we want to find greater than the date.
                if ($to instanceof \DateTimeInterface) {
                    $parameter = FilterDatabaseHelper::generateParameterName($field);

                    //  Where a time is not given the the time is set to midnight (the morning).
                    //  Because its set to midnight in the morning we have a weird UX issue.
                    //  Saying to bound today should mean ending today, so set the time to the last second in the day.
                    if ($to->format('H:i:s') === '00:00:00') {
                        $to->setTime(23, 59, 59);
                    }

                    $qb->andWhere($qb->expr()->lte($field, sprintf(':%s', $parameter)));
                    $qb->setParameter($parameter, $to);
                }
            },
        ]);
    }

    /**
     * Add a search filter.
     *
     * @param string $field
     * @param string|string $column
     */
    protected function addSearchFilter(string $field, string $column = null): void
    {
        $column = $column ?: $field;

        $this->builder->add($field, TextFilterType::class, [
            'apply_filter' => function (ORMQuery $filter, string $field, array $values) use ($column) {
                $value = $values['value'] ?? '';

                if (!FilterValueHelper::isValidSearchTerm($value)) {
                    return;
                }

                $alias = FilterDatabaseHelper::getAliasFromColumn($field);
                $field = FilterDatabaseHelper::generateFieldName($alias, $column);
                $parameter = FilterDatabaseHelper::generateParameterName($field);

                $qb = $filter->getQueryBuilder();

                //  Doctrine doesn't support the PostgreSQL ILIKE (~~*) so this will do for now.
                $qb->andWhere(
                    $qb->expr()->like(
                        $qb->expr()->lower($field),
                        $qb->expr()->lower(sprintf(':%s', $parameter))
                    )
                );

                $qb->setParameter($parameter, sprintf('%%%s%%', $value));
            },
            'constraints' => [
                new Assert\Length([
                    'min' => 3,
                    'minMessage' => sprintf('filter.%s.length.min', $field),
                ]),
            ],
        ]);
    }

    /**
     * Add a boolean filter.
     *
     * @param string $field
     * @param string|null $column
     */
    protected function addBooleanFilter(string $field, string $column = null): void
    {
        $column = $column ?: $field;

        $this->builder->add($field, TextFilterType::class, [
            'apply_filter' => function (ORMQuery $filter, string $field, array $values) use ($column) {
                $value = $values['value'] ?? '';

                if (!FilterValueHelper::isValidInput($value)) {
                    return;
                }

                $alias = FilterDatabaseHelper::getAliasFromColumn($field);
                $field = FilterDatabaseHelper::generateFieldName($alias, $column);
                $parameter = FilterDatabaseHelper::generateParameterName($field);

                $qb = $filter->getQueryBuilder();
                $qb->andWhere($qb->expr()->eq($field, sprintf(':%s', $parameter)));
                $qb->setParameter($parameter, $value);
            },
            'constraints' => [
                new Assert\Choice([
                    'choices' => [0, 1],
                    'message' => sprintf('filter.%s.choice.invalid', $field),
                ]),
            ],
        ]);

        //  Standardise the data being sent.
        $this->builder->get($field)->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {
            /** @var array|string $data */
            $data = $event->getData();

            //  Null must return here, sending anything but null will trigger validation.
            //  Even if null is wrapped in an array.
            if (is_null($data)) {
                return;
            }

            //  Fix positive.
            if (in_array(strtolower($data), ['y', 'yes', 'true', 't', '1'])) {
                $event->setData(1);
            }

            //  Fix negative.
            if (in_array(strtolower($data), ['n', 'no', 'false', 'f', '0'])) {
                $event->setData(0);
            }
        });
    }
}
