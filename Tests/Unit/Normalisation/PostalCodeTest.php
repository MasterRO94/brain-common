<?php

namespace Brain\Common\Tests\Unit\Normalisation;

use Brain\Common\Normalisation\Exception\PostalCodeInvalidException;
use Brain\Common\Normalisation\PostalCode;

use PHPUnit\Framework\TestCase;

/**
 * {@inheritdoc}
 */
final class PostalCodeTest extends TestCase
{
    /**
     * Data provider.
     *
     * @return string[][]
     */
    public function provideWithInvalidPostalCode(): array
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
     * @dataProvider provideWithInvalidPostalCode
     *
     * @group unit
     * @group normalisation
     *
     * @covers \Brain\Common\Normalisation\PostalCode
     *
     * @param string $value
     */
    public function withInvalidPostalCodeBeNice(string $value): void
    {
        $instance = new PostalCode($value, 'GB');

        self::assertFalse($instance->isValid());
    }

    /**
     * @test
     *
     * @group unit
     * @group normalisation
     *
     * @covers \Brain\Common\Normalisation\PhoneNumber
     * @covers \Brain\Common\Normalisation\Exception\PhoneNumberInvalidException
     */
    public function withInvalidPhoneNumberCannotStandardiseThrow(): void
    {
        $instance = new PostalCode('', 'GB');

        self::expectException(PostalCodeInvalidException::class);

        $instance->getStandardised();
    }

    /**
     * Data provider.
     *
     * @return string[][]
     */
    public function provideCanNormalisePostalCode(): array
    {
        return [
            ['me108aa', 'GB', 'ME108AA'],
            ['ME10 8AA', 'GB', 'ME108AA'],

            // NL
            ['2993 VD', 'NL', '2993VD'],
        ];
    }

    /**
     * @test
     * @dataProvider provideCanNormalisePostalCode
     *
     * @group unit
     * @group normalisation
     *
     * @covers \Brain\Common\Normalisation\PhoneNumber
     *
     * @param string $value
     * @param string $countryCode
     * @param string $standardised
     */
    public function canNormalisePhoneNumber(string $value, string $countryCode, string $standardised): void
    {
        $instance = new PostalCode($value, $countryCode);

        self::assertEquals($countryCode, $instance->getCountryIso());
        self::assertEquals($standardised, $instance->getStandardised());
        self::assertTrue($instance->isValid());

        $string = (string) $instance;

        self::assertEquals($standardised, $string);
    }
}