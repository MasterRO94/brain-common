<?php

declare(strict_types=1);

namespace Brain\Common\Request\Sort;

use Brain\Common\Request\Filter\Helper\EmbedFilterHelper;
use Brain\Common\Request\Filter\Helper\FilterDatabaseHelper;
use Brain\Common\Request\Sort\Enum\SortEnum;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

use Lexik\Bundle\FormFilterBundle\Filter\Doctrine\ORMQuery;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type\SharedableFilterType;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type\TextFilterType;

/**
 * {@inheritdoc}
 */
abstract class AbstractSortType extends AbstractType
{
    /** @var FormBuilderInterface */
    private $builder;

    /**
     * Build the sort form.
     *
     * @param mixed[] $options
     */
    abstract public function sort(FormBuilderInterface $builder, array $options): void;

    /**
     * {@inheritdoc}
     */
    final public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->builder = $builder;

        $this->sort($builder, $options);
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
     */
    protected function embed(string $field, string $column, string $sort): void
    {
        $listener = function (FormEvent $event) use ($field, $column, $sort): void {
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

            // Empty strings can be ignored.
            // This should cause the form handler to throw a violation.
            if ($value === '') {
                return;
            }

            $form->add($field, $sort, [
                'add_shared' => EmbedFilterHelper::embed($field, $column),
            ]);
        };

        $this->builder->addEventListener(FormEvents::PRE_SUBMIT, $listener);
    }

    /**
     * Add a sortable field.
     */
    protected function addSortableField(string $field, ?string $column = null): void
    {
        $column = $column ?: $field;
        $choices = SortEnum::getAllValues();

        $this->builder->add($field, TextFilterType::class, [
            'apply_filter' => function (ORMQuery $filter, string $field, array $values) use ($column, $choices): void {
                $value = $values['value'] ?? '';

                // The value can sometimes come through as a string.
                // In this case we just return early.
                if ($value === null || ($value === '')) {
                    return;
                }

                /** @var string $choice */
                $choice = strtoupper($value);

                if (!in_array($choice, $choices)) {
                    return;
                }

                $alias = FilterDatabaseHelper::getAliasFromColumn($field);
                $field = FilterDatabaseHelper::generateFieldName($alias, $column);

                $qb = $filter->getQueryBuilder();
                $qb->orderBy($field, $choice);
            },
            'constraints' => [
                new Assert\Choice([
                    'multiple' => false,
                    'callback' => function () use ($choices) {
                        $possible = $choices;

                        foreach ($choices as $choice) {
                            $possible[] = strtolower($choice);
                        }

                        return $possible;
                    },
                    'message' => sprintf('filter.common.sort', $field),
                    'groups' => ['filtering'],
                ]),
            ],
        ]);
    }
}
