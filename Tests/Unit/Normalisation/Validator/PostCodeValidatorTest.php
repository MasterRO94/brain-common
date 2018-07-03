<?php

namespace Brain\Common\Tests\Unit\Normalisation\Validator;

use Brain\Common\Normalisation\Validator\PostCodeValidator;

use PHPUnit\Framework\TestCase;

/**
 * {@inheritdoc}
 */
final class PostCodeValidatorTest extends TestCase
{
    /**
     * Data provider.
     *
     * @return string[][]
     */
    public function provideCanStandardiseWronglyFormattedCodes(): array
    {
        return [
            ['ME108AA', 'ME108AA'],
            ['M E108AA', 'ME108AA'],
            ['M E 108AA', 'ME108AA'],
            ['M E 10 8AA', 'ME108AA'],
            ['M E 10 8A A', 'ME108AA'],
            ['M E10 8A A', 'ME108AA'],

            // NL
            ['2993VD', '2993VD'],
            ['29 93 VD', '2993VD'],
            ['29 93 VD', '2993VD'],
            ['29 9 3 VD', '2993VD'],
        ];
    }

    /**
     * @test
     * @dataProvider provideCanStandardiseWronglyFormattedCodes
     *
     * @group unit
     * @group normalisation
     *
     * @covers \Brain\Common\Normalisation\PhoneNumber
     *
     * @param string $value
     * @param string $standardised
     */
    public function canStandardiseWronglyFormattedCodes(string $value, string $standardised): void
    {
        $validator = new PostCodeValidator();

        self::assertEquals($standardised, $validator->standardise($value));
    }
}
