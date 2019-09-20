<?php

declare(strict_types=1);

namespace Brain\Common\Form\Type\Entity;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Doctrine\ORM\QueryBuilder;

class FilterableEntityLookupType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefault('filter', static function (QueryBuilder $qb) {
        });
        $resolver->addAllowedTypes('filter', ['callable']);
    }

    /**
     * {@inheritdoc}
     */
    public function getParent(): string
    {
        return EntityLookupType::class;
    }
}
