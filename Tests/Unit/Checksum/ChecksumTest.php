<?php

declare(strict_types=1);

namespace Brain\Common\Tests\Unit\Checksum;

use Brain\Common\Checksum\Checksum;

use PHPUnit\Framework\TestCase;

/**
 * @group common
 * @group unit
 *
 * @covers \Brain\Common\Checksum\Checksum
 */
final class ChecksumTest extends TestCase
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
    public function withUpperCaseValueChecksumLower(): void
    {
        $checksum = new Checksum('some-format', 'sOME-vaLUe');

        self::assertEquals('some-format', $checksum->format());
        self::assertEquals('some-value', $checksum->toString());
    }
}
