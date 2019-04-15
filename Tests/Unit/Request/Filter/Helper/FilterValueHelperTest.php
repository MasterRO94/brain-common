<?php

declare(strict_types=1);

namespace Brain\Common\Tests\Unit\Request\Filter\Helper;

use Brain\Common\Request\Filter\Helper\FilterValueHelper;

use PHPUnit\Framework\TestCase;

/**
 * {@inheritdoc}
 */
class FilterValueHelperTest extends TestCase
{
    /**
     * Data provider.
     *
     * @return mixed[]
     */
    public function provideCanCheckValue(): array
    {
        return [
            ['', false],
            [null, false],
            [false, false],
            [' ', false],
            ['1', true],
            [1, true],
            [0, true],
        ];
    }

    /**
     * @test
     * @dataProvider provideCanCheckValue
     *
     * @group unit
     * @group core
     * @group filter
     *
     * @param mixed $input
     */
    public function canCheckValue($input, bool $expected): void
    {
        $output = FilterValueHelper::isValidInput($input);
        self::assertEquals($expected, $output);
    }

    /**
     * Data provider.
     *
     * @return mixed[]
     */
    public function provideCanCheckSearchTerm(): array
    {
        return [
            ['', false],
            [null, false],
            [false, false],
            [' ', false],
            ['1', false],
            [1, false],
            [0, false],
            ['           ', false],
            ['a', false],
            ['ab', false],
            ['abc', true],
            ['abcd', true],
        ];
    }

    /**
     * @test
     * @dataProvider provideCanCheckSearchTerm
     *
     * @group unit
     * @group core
     * @group filter
     *
     * @param mixed $input
     */
    public function canCheckSearchTerm($input, bool $expected): void
    {
        $output = FilterValueHelper::isValidSearchTerm($input);
        self::assertEquals($expected, $output);
    }
}
