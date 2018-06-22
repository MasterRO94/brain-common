<?php

namespace Brain\Common\Tests\Unit\Normalisation\Validator;

use Brain\Common\Normalisation\Validator\PostCodeValidatorFormat;

use PHPUnit\Framework\TestCase;

/**
 * {@inheritdoc}
 */
final class PostCodeValidatorFormatTest extends TestCase
{
    /**
     * @test
     *
     * @group unit
     * @group normalisation
     *
     * @covers \Brain\Common\Normalisation\Validator\PostCodeValidatorFormat
     */
    public function canCheckFormatExists(): void
    {
        self::assertTrue(PostCodeValidatorFormat::hasFormat('GB'));
        self::assertFalse(PostCodeValidatorFormat::hasFormat('WRONG'));
    }

    /**
     * @test
     *
     * @group unit
     * @group normalisation
     *
     * @covers \Brain\Common\Normalisation\Validator\PostCodeValidatorFormat
     */
    public function canGetFormat(): void
    {
        $formats = PostCodeValidatorFormat::getFormat('AE');

        self::assertInternalType('array', $formats);
        self::assertCount(0, $formats);
    }

    /**
     * Data provider.
     *
     * @return string[][]
     */
    public function provideCanConvertFormat(): array
    {
        return [
            ['#', '\d'],
            ['##', '\d\d'],

            ['@', '[A-Z]'],
            ['@@', '[A-Z][A-Z]'],

            [' ', '\s?'],
            ['  ', '\s?\s?'],

            ['#@ @#', '\d[A-Z]\s?[A-Z]\d'],
            ['#@H@#', '\d[A-Z]H[A-Z]\d'],
        ];
    }

    /**
     * @test
     * @dataProvider provideCanConvertFormat
     *
     * @group unit
     * @group normalisation
     *
     * @covers \Brain\Common\Normalisation\Validator\PostCodeValidatorFormat
     *
     * @param string $format
     * @param string $expected
     */
    public function canConvertFormat(string $format, string $expected): void
    {
        $expected = sprintf('/^%s$/', $expected);

        self::assertEquals($expected, PostCodeValidatorFormat::convertFormatToRegex($format));
    }
}
