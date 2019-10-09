<?php

declare(strict_types=1);

namespace Brain\Common\Tests\Unit\Enum\Type;

use Brain\Common\Assert\Exception\Type\ArrayTypeInvalidTypeAssertException;
use Brain\Common\Enum\EnumInterface;
use Brain\Common\Enum\Exception\TranslationInvalidForEnumException;
use Brain\Common\Enum\Exception\ValueInvalidForEnumException;
use Brain\Common\Enum\Type\Implementation\AbstractIntegerEnum;
use Brain\Common\Enum\Type\Implementation\AbstractIntegerTranslationEnum;
use Brain\Common\Exception\Developer\DeveloperContractRuntimeException;
use Brain\Common\Tests\Fixture\Enum\Type\IntegerEnumTestFixture;
use Brain\Common\Tests\Fixture\Enum\Type\StringEnumTestFixture;

use PHPUnit\Framework\TestCase;

/**
 * @group common
 * @group unit
 * @group enum
 *
 * @covers \Brain\Common\Enum\Type\AbstractEnum
 * @covers \Brain\Common\Enum\Type\Implementation\AbstractIntegerEnum
 * @covers \Brain\Common\Enum\Type\Implementation\AbstractIntegerTranslationEnum
 * @covers \Brain\Common\Enum\Exception\ValueInvalidForEnumException
 * @covers \Brain\Common\Enum\Exception\TranslationInvalidForEnumException
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
    }

    /**
     * @test
     */
    public function canGetEnumAllValue(): void
    {
        $expected = [
            1,
            0,
        ];

        self::assertEquals($expected, IntegerEnumTestFixture::all());
        self::assertEquals($expected, IntegerEnumTestFixture::all(false));
    }

    /**
     * @test
     */
    public function canGetEnumAllValueSorted(): void
    {
        $expected = [
            0,
            1,
        ];

        self::assertEquals($expected, IntegerEnumTestFixture::all(true));
    }

    /**
     * @test
     *
     * @throws ValueInvalidForEnumException
     * @throws TranslationInvalidForEnumException
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
     * @throws TranslationInvalidForEnumException
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
     * @throws TranslationInvalidForEnumException
     */
    public function withInvalidValueTranslationThrows(): void
    {
        $enum = new IntegerEnumTestFixture(IntegerEnumTestFixture::VALUE_ZERO);

        try {
            $enum::translate(2);
        } catch (ValueInvalidForEnumException $exception) {
            $regex = '/^The value "2" is not valid for enum [^\s]+. Please make sure its one of the following: 0, 1/';
            self::assertRegExp($regex, $exception->getMessage());

            self::assertEquals(IntegerEnumTestFixture::class, $exception->getEnumClass());
            self::assertEquals(2, $exception->getInvalidValue());

            $expected = [
                0,
                1,
            ];

            self::assertEquals($expected, $exception->getValues());

            return;
        }

        self::fail(sprintf('Expected exception: %s', ValueInvalidForEnumException::class));
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

    /**
     * @test
     *
     * @throws ValueInvalidForEnumException
     */
    public function withInvalidInArrayThrow(): void
    {
        $a = new IntegerEnumTestFixture(IntegerEnumTestFixture::VALUE_ZERO);

        try {
            /** @var EnumInterface[] $invalid */
            $invalid = [1, 2, 3];

            $a->in($invalid);
        } catch (ArrayTypeInvalidTypeAssertException $exception) {
            $message = 'The given array ($values) must be an array of %s';
            $message = sprintf($message, EnumInterface::class);

            self::assertEquals($message, $exception->getMessage());

            return;
        }

        self::fail(sprintf('Expected exception: %s', ArrayTypeInvalidTypeAssertException::class));
    }

    /**
     * @test
     *
     * @throws ValueInvalidForEnumException
     * @throws ArrayTypeInvalidTypeAssertException
     */
    public function canCheckStringEnumIn(): void
    {
        $a = new IntegerEnumTestFixture(IntegerEnumTestFixture::VALUE_ZERO);
        $b = new IntegerEnumTestFixture(IntegerEnumTestFixture::VALUE_ONE);
        $c = new IntegerEnumTestFixture(IntegerEnumTestFixture::VALUE_ZERO);
        $d = new StringEnumTestFixture(StringEnumTestFixture::VALUE_FOO);

        self::assertFalse($a->in([]));
        self::assertFalse($a->in([$b]));
        self::assertFalse($a->in([$d]));
        self::assertFalse($a->in([$b, $d]));

        self::assertTrue($a->in([$a]));
        self::assertTrue($a->in([$c]));
        self::assertTrue($a->in([$b, $c]));
        self::assertTrue($a->in([$a, $b]));
    }

    /**
     * @test
     *
     * @throws ValueInvalidForEnumException
     */
    public function canCheckStringEnumInValue(): void
    {
        $a = new IntegerEnumTestFixture(IntegerEnumTestFixture::VALUE_ZERO);
        $b = new IntegerEnumTestFixture(IntegerEnumTestFixture::VALUE_ONE);

        self::assertTrue($a->inValues([IntegerEnumTestFixture::VALUE_ZERO]));
        self::assertFalse($a->inValues([IntegerEnumTestFixture::VALUE_ONE]));

        self::assertTrue($b->inValues([IntegerEnumTestFixture::VALUE_ONE]));
        self::assertFalse($b->inValues([IntegerEnumTestFixture::VALUE_ZERO]));
    }

    /**
     * @test
     *
     * @throws ValueInvalidForEnumException
     */
    public function canCastEnumToString(): void
    {
        $a = new IntegerEnumTestFixture(IntegerEnumTestFixture::VALUE_ZERO);
        $b = new IntegerEnumTestFixture(IntegerEnumTestFixture::VALUE_ONE);

        self::assertEquals('enum(IntegerEnumTestFixture:0)', $a->toString());
        self::assertEquals('enum(IntegerEnumTestFixture:1)', $b->toString());
    }

    /**
     * @test
     */
    public function withInvalidTranslationThrow(): void
    {
        $enum = new class(0) extends AbstractIntegerTranslationEnum {
            /**
             * {@inheritdoc}
             */
            protected static function values(): array
            {
                return [
                    0,
                ];
            }

            /**
             * {@inheritdoc}
             */
            protected static function prefix(): string
            {
                return 'test';
            }

            /**
             * {@inheritdoc}
             */
            protected static function translations(): array
            {
                return [];
            }
        };

        try {
            $enum->translation();
        } catch (DeveloperContractRuntimeException $exception) {
            $previous = $exception->getPrevious();

            if (!($previous instanceof TranslationInvalidForEnumException)) {
                self::fail(sprintf('Expected exception: %s', TranslationInvalidForEnumException::class));
            }

            self::assertEquals(get_class($enum), $previous->getEnumClass());
            self::assertEquals(0, $previous->getInvalidTranslation());

            return;
        }

        self::fail(sprintf('Expected exception: %s', DeveloperContractRuntimeException::class));
    }
}
