<?php

declare(strict_types=1);

namespace Brain\Common\Tests\Unit\Enum\Type;

use Brain\Common\Enum\Exception\ValueInvalidForEnumException;
use Brain\Common\Enum\Type\Implementation\AbstractIntegerEnum;
use Brain\Common\Enum\Type\Implementation\AbstractIntegerTranslationEnum;

use PHPUnit\Framework\TestCase;

/**
 * @group common
 * @group unit
 * @group enum
 *
 * @covers \Brain\Common\Enum\Type\Implementation\AbstractIntegerEnum
 * @covers \Brain\Common\Enum\Type\Implementation\AbstractIntegerTranslationEnum
 */
final class IntegerEnumTest extends TestCase
{
    /**
     * @test
     */
    public function withInvalidValueConstructThrows(): void
    {
        self::expectException(ValueInvalidForEnumException::class);
        self::expectExceptionMessageRegExp('/^The value "2" is not valid for enum [^\s]+. Please make sure its one of the following: 0, 1/');

        new class(2) extends AbstractIntegerEnum {
            /**
             * {@inheritdoc}
             */
            protected static function values(): array
            {
                return [
                    0,
                    1,
                ];
            }
        };
    }

    /**
     * @test
     */
    public function canConstructBasicIntegerEnum(): void
    {
        $enum = new class(0) extends AbstractIntegerEnum {
            /**
             * {@inheritdoc}
             */
            protected static function values(): array
            {
                return [
                    0,
                    1,
                ];
            }
        };

        self::assertEquals(0, $enum->value());
        self::assertTrue($enum::has(0));
        self::assertTrue($enum::has(1));
        self::assertFalse($enum::has(2));
        self::assertFalse($enum::has(3));

        $expected = [
            0,
            1,
        ];

        self::assertEquals($expected, $enum::all());
    }

    /**
     * @test
     *
     * @throws ValueInvalidForEnumException
     */
    public function canTranslateIntegerEnum(): void
    {
        $enum = new class(0) extends AbstractIntegerTranslationEnum {
            /**
             * {@inheritdoc}
             */
            protected static function values(): array
            {
                return [
                    0,
                    1,
                ];
            }

            /**
             * {@inheritdoc}
             */
            protected static function prefix(): string
            {
                return 'prefix';
            }

            /**
             * {@inheritdoc}
             */
            protected static function translations(): array
            {
                return [
                    0 => 'zero',
                    1 => 'one',
                ];
            }
        };

        self::assertEquals('prefix.zero', $enum->translation());
        self::assertEquals('prefix.one', $enum::translate(1));
    }

    /**
     * @test
     *
     * @throws ValueInvalidForEnumException
     */
    public function withInvalidValueTranslationThrows(): void
    {
        $enum = new class(0) extends AbstractIntegerTranslationEnum {
            /**
             * {@inheritdoc}
             */
            protected static function values(): array
            {
                return [
                    0,
                    1,
                ];
            }

            /**
             * {@inheritdoc}
             */
            protected static function prefix(): string
            {
                return 'prefix';
            }

            /**
             * {@inheritdoc}
             */
            protected static function translations(): array
            {
                return [
                    0 => 'zero',
                    1 => 'one',
                ];
            }
        };

        self::expectException(ValueInvalidForEnumException::class);
        self::expectExceptionMessageRegExp('/^The value "2" is not valid for enum [^\s]+. Please make sure its one of the following: 0, 1/');

        $enum::translate(2);
    }
}
