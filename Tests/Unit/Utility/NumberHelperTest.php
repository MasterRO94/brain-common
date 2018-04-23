<?php

namespace Brain\Common\Tests\Unit\Utility;

use Brain\Common\Utility\NumberHelper;

use PHPUnit\Framework\TestCase;

/**
 * {@inheritdoc}
 */
final class NumberHelperTest extends TestCase
{
    /**
     * Data provider.
     *
     * @return array
     */
    public function provideCanClampValue(): array
    {
        return [
            [0, 0, 1, 0],
            [1, 0, 1, 1],
            [2, 0, 1, 1],
            [1.1, 0, 1, 1],
            [1.1, 1, 1, 1],
            [1.1, 1.2, 1.3, 1.2],
        ];
    }

    /**
     * @test
     * @dataProvider provideCanClampValue
     *
     * @group unit
     * @group core
     * @group utility
     *
     * @param float|int $input
     * @param int $lower
     * @param int $upper
     * @param float|int $expected
     */
    public function canClampValue($input, $lower, $upper, $expected): void
    {
        $output = NumberHelper::clamp($input, $lower, $upper);
        self::assertEquals($expected, $output);
    }
}
