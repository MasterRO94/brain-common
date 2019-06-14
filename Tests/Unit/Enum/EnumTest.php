<?php

declare(strict_types=1);

namespace Brain\Common\Tests\Unit\Enum;

use Brain\Common\Enum\AbstractEnum;
use Brain\Common\Enum\Exception\EmptyEnumException;
use Brain\Common\Enum\Exception\TranslationInvalidForEnumException;
use Brain\Common\Enum\Exception\ValueInvalidForEnumException;
use Brain\Common\Tests\Fixture\Enum\ExampleTestFixtureEnum;

use PHPUnit\Framework\TestCase;

/**
 * @group unit
 *
 * @covers \Brain\Common\Enum\AbstractEnum
 */
final class EnumTest extends TestCase
{
    /**
     * @test
     */
    public function withEmptyValuesThrow(): void
    {
        $enum = new class extends AbstractEnum {
            /**
             * {@inheritdoc}
             */
            protected static function getTranslationPrefix(): string
            {
                return '';
            }

            /**
             * {@inheritdoc}
             */
            protected static function getValues(): array
            {
                return [];
            }
        };

        self::expectException(EmptyEnumException::class);
        self::expectExceptionMessage(
            implode(' ', [
                'An enum has no values, please make sure the enum is configured correctly.',
                sprintf('The offending enum is: %s', get_class($enum)),
            ])
        );

        $enum::getAllValues();
    }

    /**
     * @test
     */
    public function canGetAllValues(): void
    {
        $values = ExampleTestFixtureEnum::getAllValues();

        $expected = [
            'valid',
            'normal',
        ];

        self::assertEquals($expected, $values);
    }

    /**
     * @test
     */
    public function canGetAllTranslations(): void
    {
        $values = ExampleTestFixtureEnum::getAllTranslations();

        $expected = [
            'prefix.valid',
            'prefix.normal',
        ];

        self::assertEquals($expected, $values);
    }

    /**
     * @test
     */
    public function canGetMapping(): void
    {
        $mapping = ExampleTestFixtureEnum::getMapping();

        $expected = [
            'valid' => 'prefix.valid',
            'normal' => 'prefix.normal',
        ];

        self::assertEquals($expected, $mapping);
    }

    /**
     * @test
     */
    public function withInvalidValueCannotTranslate(): void
    {
        self::expectException(ValueInvalidForEnumException::class);
        self::expectExceptionMessage(implode(' ', [
            sprintf('The value "asdf" is not valid for enum %s.', ExampleTestFixtureEnum::class),
            'Please make sure its one of the following: valid, normal',
        ]));

        ExampleTestFixtureEnum::translate('asdf');
    }

    /**
     * @test
     */
    public function canTranslateValue(): void
    {
        $translated = ExampleTestFixtureEnum::translate('valid');

        self::assertEquals('prefix.valid', $translated);
    }

    /**
     * @test
     */
    public function withInvalidTranslationCannotValue(): void
    {
        self::expectException(TranslationInvalidForEnumException::class);
        self::expectExceptionMessage(implode(' ', [
            sprintf('The translation "asdf" is not valid for enum %s.', ExampleTestFixtureEnum::class),
            'Please make sure its one of the following: prefix.valid, prefix.normal',
        ]));

        ExampleTestFixtureEnum::valueFromTranslation('asdf');
    }

    /**
     * @test
     */
    public function canValueTranslation(): void
    {
        $value = ExampleTestFixtureEnum::valueFromTranslation('prefix.valid');

        self::assertEquals('valid', $value);
    }
}
