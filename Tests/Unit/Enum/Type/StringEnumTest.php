<?php

declare(strict_types=1);

namespace Brain\Common\Tests\Unit\Enum\Type;

use Brain\Common\Enum\Exception\ValueInvalidForEnumException;
use Brain\Common\Enum\Type\Implementation\AbstractStringEnum;
use Brain\Common\Tests\Fixture\Enum\Type\StringEnumTestFixture;

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
     *
     * @throws ValueInvalidForEnumException
     */
    public function withInvalidValueConstructThrows(): void
    {
        self::expectException(ValueInvalidForEnumException::class);
        self::expectExceptionMessageRegExp('/^The value "tony" is not valid for enum [^\s]+. Please make sure its one of the following: foo, bar/');

        new StringEnumTestFixture('tony');
    }

    /**
     * @test
     *
     * @throws ValueInvalidForEnumException
     */
    public function canConstructBasicStringEnum(): void
    {
        $enum = new StringEnumTestFixture(StringEnumTestFixture::VALUE_FOO);

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
        $enum = new StringEnumTestFixture(StringEnumTestFixture::VALUE_FOO);

        self::assertEquals('enum.string.foo', $enum->translation());
        self::assertEquals('enum.string.bar', $enum::translate('bar'));
    }

    /**
     * @test
     *
     * @throws ValueInvalidForEnumException
     */
    public function withInvalidValueTranslationThrows(): void
    {
        $enum = new StringEnumTestFixture(StringEnumTestFixture::VALUE_FOO);

        self::expectException(ValueInvalidForEnumException::class);
        self::expectExceptionMessageRegExp('/^The value "tony" is not valid for enum [^\s]+. Please make sure its one of the following: foo, bar/');

        $enum::translate('tony');
    }

    /**
     * @test
     */
    public function withNonMatchingEnumCannotCompareValue(): void
    {
        $enum = new class('foo') extends AbstractStringEnum {
            /**
             * {@inheritdoc}
             */
            protected static function values(): array
            {
                return [
                    'foo',
                ];
            }
        };

        $compare = new StringEnumTestFixture(StringEnumTestFixture::VALUE_FOO);

        self::assertTrue($enum->isValue($compare->value()));
        self::assertFalse($enum->is($compare));
    }

    /**
     * @test
     *
     * @throws ValueInvalidForEnumException
     */
    public function canCheckStringEnumIs(): void
    {
        $a = new StringEnumTestFixture(StringEnumTestFixture::VALUE_FOO);
        $b = new StringEnumTestFixture(StringEnumTestFixture::VALUE_BAR);
        $c = new StringEnumTestFixture(StringEnumTestFixture::VALUE_FOO);

        self::assertFalse($a->is($b));
        self::assertTrue($a->is($c));
    }

    /**
     * @test
     *
     * @throws ValueInvalidForEnumException
     */
    public function canCheckStringEnumIsValue(): void
    {
        $a = new StringEnumTestFixture(StringEnumTestFixture::VALUE_FOO);
        $b = new StringEnumTestFixture(StringEnumTestFixture::VALUE_BAR);

        self::assertTrue($a->isValue(StringEnumTestFixture::VALUE_FOO));
        self::assertFalse($a->isValue(StringEnumTestFixture::VALUE_BAR));

        self::assertTrue($b->isValue(StringEnumTestFixture::VALUE_BAR));
        self::assertFalse($b->isValue(StringEnumTestFixture::VALUE_FOO));
    }
}
