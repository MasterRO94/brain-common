<?php

declare(strict_types=1);

namespace Brain\Common\Tests\Unit\Regex;

use Brain\Common\Regex\RegexMatch;

use PHPUnit\Framework\TestCase;

/**
 * @group common
 * @group unit
 * @group regex
 *
 * @covers \Brain\Common\Regex\RegexMatch
 */
final class RegexMatchTest extends TestCase
{
    /**
     * @test
     */
    public function canDetectInvalidMatch(): void
    {
        $match = RegexMatch::match('/\d/', 'as');

        self::assertFalse($match);
    }

    /**
     * @test
     */
    public function canDetectValidMatch(): void
    {
        $match = RegexMatch::match('/\d/', '3');

        self::assertTrue($match);
    }
}
