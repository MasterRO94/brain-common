<?php

declare(strict_types=1);

namespace Brain\Common\Tests\Unit\Checksum\Format;

use Brain\Common\Checksum\Checksum;
use Brain\Common\Checksum\Exception\ChecksumInvalidForFormatException;
use Brain\Common\Checksum\Format\ShaChecksum;

use PHPUnit\Framework\TestCase;

/**
 * @group common
 * @group unit
 *
 * @covers \Brain\Common\Checksum\Format\ShaChecksum
 * @covers \Brain\Common\Checksum\Exception\ChecksumInvalidForFormatException
 */
final class ShaChecksumTest extends TestCase
{
    /**
     * @test
     */
    public function canCreateChecksum(): void
    {
        $checksum = new Checksum('some-format', 'some-value');

        self::assertEquals('some-format', $checksum->format());
        self::assertEquals('some-value', $checksum->toString());
    }

    /**
     * @test
     */
    public function withInvalidSHA1throw(): void
    {
        try {
            ShaChecksum::sha1('some-value', true);
        } catch (ChecksumInvalidForFormatException $exception) {
            $message = 'The checksum value "some-value" is invalid for format "sha1".';

            self::assertEquals($message, $exception->getMessage());
            self::assertEquals('sha1', $exception->getChecksumFormat());
            self::assertEquals('some-value', $exception->getInvalidValue());

            return;
        }

        self::fail(sprintf('Expected exception: %s', ChecksumInvalidForFormatException::class));
    }

    /**
     * @test
     *
     * @throws ChecksumInvalidForFormatException
     */
    public function canCreateSHA1(): void
    {
        $checksum = ShaChecksum::sha1('c1b24294f00e281605f9dd6a298612e3060062b4', true);

        self::assertEquals('sha1', $checksum->format());
        self::assertEquals('c1b24294f00e281605f9dd6a298612e3060062b4', $checksum->toString());
    }

    /**
     * @test
     *
     * @throws ChecksumInvalidForFormatException
     */
    public function canGenerateSHA1(): void
    {
        $checksum = ShaChecksum::sha1('some-value', false);

        self::assertEquals('sha1', $checksum->format());
        self::assertEquals('c1b24294f00e281605f9dd6a298612e3060062b4', $checksum->toString());
    }

    /**
     * @test
     */
    public function withInvalidSHA256throw(): void
    {
        try {
            ShaChecksum::sha256('another-value', true);
        } catch (ChecksumInvalidForFormatException $exception) {
            $message = 'The checksum value "another-value" is invalid for format "sha256".';

            self::assertEquals($message, $exception->getMessage());
            self::assertEquals('sha256', $exception->getChecksumFormat());
            self::assertEquals('another-value', $exception->getInvalidValue());

            return;
        }

        self::fail(sprintf('Expected exception: %s', ChecksumInvalidForFormatException::class));
    }

    /**
     * @test
     *
     * @throws ChecksumInvalidForFormatException
     */
    public function canCreateSHA256(): void
    {
        $checksum = ShaChecksum::sha256('700f3c597d9a0db5fc2dcc41c8d9b650d64ba0ed979dc00f1e3dea17fca07a1f', true);

        self::assertEquals('sha256', $checksum->format());
        self::assertEquals('700f3c597d9a0db5fc2dcc41c8d9b650d64ba0ed979dc00f1e3dea17fca07a1f', $checksum->toString());
    }

    /**
     * @test
     *
     * @throws ChecksumInvalidForFormatException
     */
    public function canGenerateSHA256(): void
    {
        $checksum = ShaChecksum::sha256('some-value', false);

        self::assertEquals('sha256', $checksum->format());
        self::assertEquals('700f3c597d9a0db5fc2dcc41c8d9b650d64ba0ed979dc00f1e3dea17fca07a1f', $checksum->toString());
    }
}
