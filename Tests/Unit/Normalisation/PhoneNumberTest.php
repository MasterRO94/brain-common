<?php

namespace Brain\Common\Tests\Unit\Normalisation;

use Brain\Common\Normalisation\Exception\PhoneNumberInvalidException;
use Brain\Common\Normalisation\PhoneNumber;

use PHPUnit\Framework\TestCase;

/**
 * {@inheritdoc}
 */
final class PhoneNumberTest extends TestCase
{
    /**
     * Data provider.
     *
     * @return string[][]
     */
    public function provideWithInvalidPhoneNumberBeNice(): array
    {
        return [
            [''],
            ['0'],
            ['1'],
            ['00'],
            ['ddd'],
            ['////'],
        ];
    }

    /**
     * @test
     * @dataProvider provideWithInvalidPhoneNumberBeNice
     *
     * @group unit
     * @group normalisation
     *
     * @covers \Brain\Common\Normalisation\PhoneNumber
     *
     * @param string $value
     */
    public function withInvalidPhoneNumberBeNice(string $value): void
    {
        $instance = new PhoneNumber($value, 'GB');

        self::assertFalse($instance->isValid());
    }

    /**
     * @test
     * @dataProvider provideWithInvalidPhoneNumberBeNice
     *
     * @group unit
     * @group normalisation
     *
     * @covers \Brain\Common\Normalisation\PhoneNumber
     * @covers \Brain\Common\Normalisation\Exception\PhoneNumberInvalidException
     */
    public function withInvalidPhoneNumberGetterThrows(): void
    {
        $instance = new PhoneNumber('', 'GB');

        self::expectException(PhoneNumberInvalidException::class);

        $instance->getExtensionInstance();
    }

    /**
     * Data provider.
     *
     * @return string[][]
     */
    public function provideCanNormalisePhoneNumber(): array
    {
        return [
            ['0800 840 1430', 44, '8008401430', '+448008401430'],
            ['0800 840 1431', 44, '8008401431', '+448008401431'],
            ['01670 432 067', 44, '1670432067', '+441670432067'],
            ['07809 123 456', 44, '7809123456', '+447809123456'],

            // NL
            ['00 31 20 555 1111', 31, '205551111', '+31205551111'],
        ];
    }

    /**
     * @test
     * @dataProvider provideCanNormalisePhoneNumber
     *
     * @group unit
     * @group normalisation
     *
     * @covers \Brain\Common\Normalisation\PhoneNumber
     *
     * @param string $value
     * @param string $countryCode
     * @param string $nationalNumber
     * @param string $standardised
     */
    public function canNormalisePhoneNumber(string $value, string $countryCode, string $nationalNumber, string $standardised): void
    {
        $instance = new PhoneNumber($value, 'GB');

        self::assertEquals($countryCode, $instance->getCountryCode());
        self::assertEquals($nationalNumber, $instance->getNationalNumber());
        self::assertEquals($standardised, $instance->getStandardisedNumber());
        self::assertTrue($instance->isValid());

        $string = (string) $instance;

        self::assertEquals($standardised, $string);
    }
}
