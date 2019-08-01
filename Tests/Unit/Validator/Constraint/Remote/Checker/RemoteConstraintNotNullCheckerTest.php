<?php

declare(strict_types=1);

namespace Brain\Common\Tests\Unit\Validator\Constraint\Remote\Checker;

use Brain\Common\Validator\Constraint\Remote\Checker\RemoteConstraintNotNullChecker;

use PHPUnit\Framework\TestCase;

/**
 * @group unit
 * @group common
 * @group validator
 *
 * @covers \Brain\Common\Validator\Constraint\Remote\Checker\RemoteConstraintNotNullChecker
 */
final class RemoteConstraintNotNullCheckerTest extends TestCase
{
    /**
     * Data provider.
     *
     * @return mixed[]
     */
    public function provideCanCheckNull(): array
    {
        return [
            [true, 0],
            [true, 1],
            [true, ''],
            [true, 'foo'],
            [true, []],
            [true, false],
            [true, true],

            [false, null],
        ];
    }

    /**
     * @test
     * @dataProvider provideCanCheckNull
     *
     * @param mixed $value
     */
    public function canCheckNull(bool $expected, $value): void
    {
        $checker = new RemoteConstraintNotNullChecker();

        self::assertEquals($expected, $checker->check($value));
    }
}
