<?php

declare(strict_types=1);

namespace Brain\Common\Form\Lookup\Size;

use Brain\Bundle\Stock\Entity\Size\Size;

use Brain\Common\Form\Type\Entity\EntityLookupPreset;
use Brain\Common\Form\Type\Entity\EntityLookupType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @see SizeInterface
 * @see Size
 */
final class SizeEntityLookupType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'class' => Size::class,
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
