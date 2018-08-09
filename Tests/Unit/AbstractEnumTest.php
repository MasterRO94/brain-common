<?php

declare(strict_types=1);

namespace Brain\Common\Tests\Unit;

use Brain\Common\Enum\AbstractEnum;

use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionException;

/**
 * {@inheritdoc}
 *
 * Tests enum classes for you.
 */
abstract class AbstractEnumTest extends TestCase
{
    /**
     * Return the enum class for testing.
     */
    abstract public function getEnumClass(): string;

    /**
     * Return the statuses expected.
     *
     * Make sure you do not use constants here.
     * The test should fail if a constant is changed.
     *
     * @return string[]
     */
    abstract public function getExpectedValueTranslationMap(): array;

    /**
     * Data provider.
     *
     * @throws ReflectionException
     *
     * @return mixed[]
     */
    public function provideCheckAllConstantMentioned(): array
    {
        $reflector = new ReflectionClass($this->getEnumClass());

        $provider = [];

        foreach ($reflector->getConstants() as $constant) {
            $provider[] = [$constant];
        }

        return $provider;
    }

    /**
     * @test
     * @dataProvider provideCheckAllConstantMentioned
     *
     * @group core
     * @group enum
     *
     * @covers \Brain\Common\Enum\AbstractEnum
     */
    public function checkAllConstantMentioned(string $constant): void
    {
        $mapping = $this->getExpectedValueTranslationMap();

        self::assertArrayHasKey($constant, $mapping, 'Make sure the test is updated for this constant!');
    }

    /**
     * Data provider.
     *
     * @return mixed[]
     */
    public function provideCanTranslateEnumValue(): array
    {
        $provider = [];

        foreach ($this->getExpectedValueTranslationMap() as $value => $translation) {
            $provider[] = [
                $translation,
                $value,
            ];
        }

        return $provider;
    }

    /**
     * @test
     * @dataProvider provideCanTranslateEnumValue
     *
     * @group core
     * @group enum
     *
     * @covers \Brain\Common\Enum\AbstractEnum
     */
    public function canTranslateEnumValue(string $expected, string $value): void
    {
        /** @var AbstractEnum $enum */
        $enum = $this->getEnumClass();

        self::assertEquals($expected, $enum::translate($value));
    }

    /**
     * Data provider.
     *
     * @return mixed[]
     */
    public function provideCanValueEnumTranslation(): array
    {
        $provider = [];

        foreach ($this->getExpectedValueTranslationMap() as $value => $translation) {
            $provider[] = [
                $value,
                $translation,
            ];
        }

        return $provider;
    }

    /**
     * @test
     * @dataProvider provideCanValueEnumTranslation
     *
     * @group core
     * @group enum
     *
     * @covers \Brain\Common\Enum\AbstractEnum
     */
    public function canValueEnumTranslation(string $expected, string $translation): void
    {
        /** @var AbstractEnum $enum */
        $enum = $this->getEnumClass();

        self::assertEquals($expected, $enum::value($translation));
    }
}
