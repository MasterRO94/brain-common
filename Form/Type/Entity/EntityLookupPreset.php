<?php

declare(strict_types=1);

namespace Brain\Common\Form\Type\Entity;

final class EntityLookupPreset
{
    /**
     * A preset (what I would call) generic lookup definition.
     *
     * @return EntityLookupDefinition[]
     */
    public static function generic(): array
    {
        return array_merge(
            self::id(),
            self::alias()
        );
    }

    /**
     * A preset id lookup definition.
     *
     * @return EntityLookupDefinition[]
     */
    public static function id(): array
    {
        return [
            'id' => EntityLookupDefinition::create('publicId')->setRegexIdentity(),
        ];
    }

    /**
     * A preset alias lookup definition.
     *
     * @return EntityLookupDefinition[]
     */
    public static function alias(): array
    {
        return [
            'alias' => EntityLookupDefinition::create('publicAlias'),
        ];
    }
}
