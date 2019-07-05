<?php

declare(strict_types=1);

namespace Brain\Common\Tests\Unit\Database\Query\Helper;

use Brain\Common\Database\Query\Helper\DatabaseQueryHelper;

use PHPUnit\Framework\TestCase;

/**
 * @group common
 * @group unit
 * @group database
 *
 * @covers \Brain\Common\Database\Query\Helper\DatabaseQueryHelper
 */
final class DatabaseQueryHelperTest extends TestCase
{
    /**
     * @test
     */
    public function canReturnValidPlaceholder(): void
    {
        $placeholder = DatabaseQueryHelper::placeholder();

        self::assertStringStartsWith('TRUE', $placeholder);
    }

    /**
     * @test
     */
    public function canStringEmptyList(): void
    {
        $string = DatabaseQueryHelper::list([]);

        self::assertEquals('', $string);
    }

    /**
     * @test
     */
    public function canStringList(): void
    {
        $string = DatabaseQueryHelper::list([1, 2, 3, 4, 5]);

        self::assertEquals('1, 2, 3, 4, 5', $string);
    }

    /**
     * @test
     */
    public function canTemplateEmptyParameters(): void
    {
        $input = 'foo :foo';
        $parameters = [];

        $template = DatabaseQueryHelper::template($input, $parameters);

        self::assertEquals('foo :foo', $template);
    }

    /**
     * @test
     */
    public function canTemplateParameters(): void
    {
        $input = 'foo :foo';
        $parameters = [
            'foo' => 'bar',
        ];

        $template = DatabaseQueryHelper::template($input, $parameters);

        self::assertEquals('foo bar', $template);
    }

    /**
     * @test
     */
    public function canBreakListToIds(): void
    {
        $ids = DatabaseQueryHelper::ids('1,2,3,4');

        self::assertEquals([1, 2, 3, 4], $ids);
    }
}
