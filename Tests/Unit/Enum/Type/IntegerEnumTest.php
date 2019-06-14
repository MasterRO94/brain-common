<?php

declare(strict_types=1);

namespace Brain\Common\Tests\Unit\Enum\Type;

use Brain\Common\Enum\Exception\ValueInvalidForEnumException;
use Brain\Common\Enum\Type\Implementation\AbstractIntegerEnum;
use Brain\Common\Tests\Fixture\Enum\Type\IntegerEnumTestFixture;

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
     *
     * @throws ValueInvalidForEnumException
     */
    public function withInvalidValueConstructThrows(): void
    {
        self::expectException(ValueInvalidForEnumException::class);
        self::expectExceptionMessageRegExp('/^The value "2" is not valid for enum [^\s]+. Please make sure its one of the following: 0, 1/');

        new IntegerEnumTestFixture(2);
    }

    /**
     * @test
     *
     * @throws ValueInvalidForEnumException
     */
    public function canConstructBasicIntegerEnum(): void
    {
        $enum = new IntegerEnumTestFixture(IntegerEnumTestFixture::VALUE_ZERO);

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
        $enum = new IntegerEnumTestFixture(IntegerEnumTestFixture::VALUE_ZERO);

        self::assertEquals('enum.integer.zero', $enum->translation());
        self::assertEquals('enum.integer.one', $enum::translate(1));
    }

    /**
     * @test
     *
     * @throws ValueInvalidForEnumException
     */
    public function canGetNonPrefixTranslation(): void
    {
        $enum = new IntegerEnumTestFixture(IntegerEnumTestFixture::VALUE_ZERO);

        self::assertEquals('zero', $enum->translation(false));
        self::assertEquals('one', $enum::translate(1, false));
    }

    /**
     * @test
     *
     * @throws ValueInvalidForEnumException
     */
    public function withInvalidValueTranslationThrows(): void
    {
        $enum = new IntegerEnumTestFixture(IntegerEnumTestFixture::VALUE_ZERO);

        self::expectException(ValueInvalidForEnumException::class);
        self::expectExceptionMessageRegExp('/^The value "2" is not valid for enum [^\s]+. Please make sure its one of the following: 0, 1/');

        $enum::translate(2);
    }

    /**
     * @test
     */
    public function withNonMatchingEnumCannotCompareValue(): void
    {
        $enum = new class(0) extends AbstractIntegerEnum {
            /**
             * {@inheritdoc}
             */
            protected static function values(): array
            {
                return [
                    0,
                ];
            }
        };

        $compare = new IntegerEnumTestFixture(IntegerEnumTestFixture::VALUE_ZERO);

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
        $a = new IntegerEnumTestFixture(IntegerEnumTestFixture::VALUE_ZERO);
        $b = new IntegerEnumTestFixture(IntegerEnumTestFixture::VALUE_ONE);
        $c = new IntegerEnumTestFixture(IntegerEnumTestFixture::VALUE_ZERO);

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
        $a = new IntegerEnumTestFixture(IntegerEnumTestFixture::VALUE_ZERO);
        $b = new IntegerEnumTestFixture(IntegerEnumTestFixture::VALUE_ONE);

        self::assertTrue($a->isValue(IntegerEnumTestFixture::VALUE_ZERO));
        self::assertFalse($a->isValue(IntegerEnumTestFixture::VALUE_ONE));

        self::assertTrue($b->isValue(IntegerEnumTestFixture::VALUE_ONE));
        self::assertFalse($b->isValue(IntegerEnumTestFixture::VALUE_ZERO));
    }
}
