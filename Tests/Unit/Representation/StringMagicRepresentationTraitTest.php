<?php

declare(strict_types=1);

namespace Brain\Common\Tests\Unit\Representation;

use Brain\Common\Debug\Representation\DebugRepresentationInterface;
use Brain\Common\Representation\StringMagicRepresentationTrait;
use Brain\Common\Representation\Type\StringRepresentationInterface;
use Brain\Common\Tests\Fixture\Representation\WithoutRepresentationTestFixture;

use PHPUnit\Framework\TestCase;

/**
 * @group common
 * @group unit
 * @group representation
 *
 * @covers \Brain\Common\Representation\StringMagicRepresentationTrait
 */
final class StringMagicRepresentationTraitTest extends TestCase
{
    /**
     * @test
     */
    public function canRepresentClassAsString(): void
    {
        $class = new class implements StringRepresentationInterface {
            use StringMagicRepresentationTrait;

            /**
             * {@inheritdoc}
             */
            public function toString(): string
            {
                return 'as-string';
            }
        };

        self::assertEquals('as-string', $class->__toString());
    }

    /**
     * @test
     */
    public function canRepresentClassAsDebug(): void
    {
        $class = new class implements DebugRepresentationInterface {
            use StringMagicRepresentationTrait;

            /**
             * {@inheritdoc}
             */
            public function toDebug(bool $short): string
            {
                return 'as-debug';
            }
        };

        self::assertEquals('as-debug', $class->__toString());
    }

    /**
     * @test
     */
    public function canRepresentClassAsShortNameAsFallback(): void
    {
        $class = new WithoutRepresentationTestFixture();

        self::assertEquals('WithoutRepresentationTestFixture', $class->__toString());
    }
}
