<?php

declare(strict_types=1);

namespace Brain\Common\Form\Lookup\Material;

use Brain\Bundle\Stock\Database\EntityInterface\MaterialInterface;
use Brain\Bundle\Stock\Entity\Material;

use Brain\Common\Form\Type\Entity\EntityLookupPreset;
use Brain\Common\Form\Type\Entity\EntityLookupType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @see MaterialInterface
 * @see Material
 */
final class MaterialEntityLookupType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'class' => Material::class,
            'columns' => EntityLookupPreset::generic(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getParent(): string
    {
        return EntityLookupType::class;
    }
}
