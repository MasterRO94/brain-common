<?php

declare(strict_types=1);

namespace Brain\Common\Tests\Unit\Checksum;

use Brain\Common\Checksum\ChecksumRegex;

use PHPUnit\Framework\TestCase;

/**
 * @group common
 * @group unit
 *
 * @covers \Brain\Common\Checksum\ChecksumRegex
 */
final class ChecksumRegexTest extends TestCase
{
    /**
     * Data provider.
     *
     * @return mixed[]
     */
    public function provideCanCheckMD5(): array
    {
        $provider = [
            [false, ''],
            [false, 'abc'],
            [false, 'abcdefg'],

            [false, '0'],
            [false, '01'],

            [true, 'abcdefabcdefabcdefabcdefabcdefab'],
            [true, '01234567890123456789012345678901'],

            [true, 'B3AF409BB8423187C75E6C7F5B683908'],
            [true, 'F61B26D635309536C3C83C0ADC3CB972'],
        ];

        foreach (range(1, 100) as $number) {
            $name = sprintf('dynamic-%d', $number);
            $provider[$name] = [true, hash('md5', sprintf('value-%d', $number))];
        }

        return $provider;
    }

    /**
     * @test
     * @dataProvider provideCanCheckMD5
     */
    public function canCheckMD5(bool $expected, string $value): void
    {
        self::assertEquals($expected, ChecksumRegex::isMD5($value));
    }

    /**
     * Data provider.
     *
     * @return mixed[]
     */
    public function provideCanCheckSHA1(): array
    {
        $provider = [
            [false, ''],
            [false, 'abc'],
            [false, 'abcdefg'],

            [false, '0'],
            [false, '01'],

            // MD5
            [false, 'abcdefabcdefabcdefabcdefabcdefab'],
            [false, '01234567890123456789012345678901'],
            [false, 'b3af409bb8423187c75e6c7f5b683908'],
            [false, 'f61b26d635309536c3c83c0adc3cb972'],

            [true, 'abcdefabcdefabcdefabcdefabcdefabcdefabcd'],
            [true, '0123456789012345678901234567890123456789'],

            [true, '3DA541559918A808C2402BBA5012F6C60B27661C'],
            [true, '5163C01DEAF54C2A814C71A2A214A241F3BF680B'],
        ];

        foreach (range(1, 100) as $number) {
            $name = sprintf('dynamic-%d', $number);
            $provider[$name] = [true, hash('sha1', sprintf('value-%d', $number))];
        }

        return $provider;
    }

    /**
     * @test
     * @dataProvider provideCanCheckSHA1
     */
    public function canCheckSHA1(bool $expected, string $value): void
    {
        self::assertEquals($expected, ChecksumRegex::isSHA1($value));
    }

    /**
     * Data provider.
     *
     * @return mixed[]
     */
    public function provideCanCheckSHA256(): array
    {
        $provider = [
            [false, ''],
            [false, 'abc'],
            [false, 'abcdefg'],

            [false, '0'],
            [false, '01'],

            // MD5
            [false, 'abcdefabcdefabcdefabcdefabcdefab'],
            [false, '01234567890123456789012345678901'],
            [false, 'b3af409bb8423187c75e6c7f5b683908'],
            [false, 'f61b26d635309536c3c83c0adc3cb972'],

            // SHA1
            [false, 'abcdefabcdefabcdefabcdefabcdefabcdefabcd'],
            [false, '0123456789012345678901234567890123456789'],
            [false, '3DA541559918A808C2402BBA5012F6C60B27661C'],
            [false, '5163C01DEAF54C2A814C71A2A214A241F3BF680B'],

            [true, 'abcdefabcdefabcdefabcdefabcdefababcdefabcdefabcdefabcdefabcdefab'],
            [true, '0123456789012345678901234567890101234567890123456789012345678901'],

            [true, '3DA541559918A808C2402BBA5012F6C60B27661C3DA541559918A808C2402BBA'],
            [true, '5163C01DEAF54C2A814C71A2A214A241F3BF680B5163C01DEAF54C2A814C71A2'],
        ];

        foreach (range(1, 100) as $number) {
            $name = sprintf('dynamic-%d', $number);
            $provider[$name] = [true, hash('sha256', sprintf('value-%d', $number))];
        }

        return $provider;
    }

    /**
     * @test
     * @dataProvider provideCanCheckSHA256
     */
    public function canCheckSHA256(bool $expected, string $value): void
    {
        self::assertEquals($expected, ChecksumRegex::isSHA256($value));
    }
}
