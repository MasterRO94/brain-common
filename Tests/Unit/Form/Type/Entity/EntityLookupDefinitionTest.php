<?php

declare(strict_types=1);

namespace Brain\Common\Tests\Unit\Form\Type\Entity;

use Brain\Common\Form\Type\Entity\EntityLookupDefinition;

use PHPUnit\Framework\TestCase;

/**
 * @group common
 * @group form
 *
 * @covers \Brain\Common\Form\Type\Entity\EntityLookupDefinition
 */
final class EntityLookupDefinitionTest extends TestCase
{
    /**
     * @test
     */
    public function canCreateBasic(): void
    {
        $definition = EntityLookupDefinition::create('foo');

        self::assertEquals('foo', $definition->getColumn());

        self::assertEquals('string', $definition->getType());
        self::assertTrue($definition->isTypeString());
        self::assertFalse($definition->isTypeInteger());

        self::assertNull($definition->getDefault());
        self::assertNull($definition->getRegex());
    }

    /**
     * @test
     */
    public function canChangeTypeToInteger(): void
    {
        $definition = EntityLookupDefinition::create('foo');
        $definition->setTypeInteger();

        self::assertEquals('integer', $definition->getType());
        self::assertTrue($definition->isTypeInteger());
        self::assertFalse($definition->isTypeString());
    }
}
