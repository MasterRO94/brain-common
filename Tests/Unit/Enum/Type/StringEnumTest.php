<?php

declare(strict_types=1);

namespace Brain\Common\Tests\Unit\Enum\Type;

use Brain\Common\Enum\Exception\ValueInvalidForEnumException;
use Brain\Common\Enum\Type\Implementation\AbstractStringEnum;
use Brain\Common\Enum\Type\Implementation\AbstractStringTranslationEnum;

use PHPUnit\Framework\TestCase;

/**
 * @group common
 * @group unit
 * @group enum
 *
 * @covers \Brain\Common\Enum\Type\Implementation\AbstractStringEnum
 * @covers \Brain\Common\Enum\Type\Implementation\AbstractStringTranslationEnum
 */
final class StringEnumTest extends TestCase
{
    /**
     * @test
     */
    public function withInvalidValueConstructThrows(): void
    {
        self::expectException(ValueInvalidForEnumException::class);
        self::expectExceptionMessageRegExp('/^The value "tony" is not valid for enum [^\s]+. Please make sure its one of the following: foo, bar/');

        new class('tony') extends AbstractStringEnum {
            /**
             * {@inheritdoc}
             */
            protected static function values(): array
            {
                return [
                    'foo',
                    'bar',
                ];
            }
        };
    }

    /**
     * @test
     */
    public function canConstructBasicStringEnum(): void
    {
        $enum = new class('foo') extends AbstractStringEnum {
            /**
             * {@inheritdoc}
             */
            protected static function values(): array
            {
                return [
                    'foo',
                    'bar',
                ];
            }
        };

        self::assertEquals('foo', $enum->value());
        self::assertTrue($enum::has('foo'));
        self::assertTrue($enum::has('bar'));
        self::assertFalse($enum::has('tony'));
        self::assertFalse($enum::has('stark'));

        $expected = [
            'foo',
            'bar',
        ];

        self::assertEquals($expected, $enum::all());
    }

    /**
     * @test
     *
     * @throws ValueInvalidForEnumException
     */
    public function canTranslateStringEnum(): void
    {
        $enum = new class('foo') extends AbstractStringTranslationEnum {
            /**
             * {@inheritdoc}
             */
            protected static function values(): array
            {
                return [
                    'foo',
                    'bar',
                ];
            }

            /**
             * {@inheritdoc}
             */
            protected static function prefix(): string
            {
                return 'prefix';
            }
        };

        self::assertEquals('prefix.foo', $enum->translation());
        self::assertEquals('prefix.bar', $enum::translate('bar'));
    }

    /**
     * @test
     *
     * @throws ValueInvalidForEnumException
     */
    public function withInvalidValueTranslationThrows(): void
    {
        $enum = new class('foo') extends AbstractStringTranslationEnum {
            /**
             * {@inheritdoc}
             */
            protected static function values(): array
            {
                return [
                    'foo',
                    'bar',
                ];
            }

            /**
             * {@inheritdoc}
             */
            protected static function prefix(): string
            {
                return 'prefix';
            }
        };

        self::expectException(ValueInvalidForEnumException::class);
        self::expectExceptionMessageRegExp('/^The value "tony" is not valid for enum [^\s]+. Please make sure its one of the following: foo, bar/');

        $enum::translate('tony');
    }
}
