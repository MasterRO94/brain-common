<?php

namespace Brain\Common\Tests\Unit\Request\Filter\Helper;

use Brain\Common\Request\Filter\Helper\FilterDatabaseHelper;

use PHPUnit\Framework\TestCase;

/**
 * {@inheritdoc}
 */
class FilterDatabaseHelperTest extends TestCase
{
    /**
     * Data provider.
     *
     * @return array
     */
    public function provideCanGenerateParameterName(): array
    {
        return [
            ['foo', 'filter_Foo'],
            ['fooBar', 'filter_FooBar'],
            ['foo_bar', 'filter_FooBar'],
            ['foo-bar', 'filter_FooBar'],

            ['alias.foo', 'filter_AliasFoo'],
            ['alias.fooBar', 'filter_AliasFooBar'],
            ['alias.foo_bar', 'filter_AliasFooBar'],
            ['alias.foo-bar', 'filter_AliasFooBar'],

            ['aliasAgain.foo', 'filter_AliasAgainFoo'],
            ['aliasAgain.fooBar', 'filter_AliasAgainFooBar'],
        ];
    }

    /**
     * @test
     * @dataProvider provideCanGenerateParameterName
     *
     * @group unit
     * @group core
     * @group filter
     *
     * @param string $input
     * @param string $expected
     */
    public function canGenerateParameterName(string $input, string $expected): void
    {
        $output = FilterDatabaseHelper::generateParameterName($input);
        self::assertStringStartsWith($expected, $output);
    }

    /**
     * Data provider.
     *
     * @return array
     */
    public function provideCanGenerateFieldName(): array
    {
        return [
            [null, 'foo', 'foo'],
            [null, 'fooBar', 'fooBar'],

            ['', 'foo', 'foo'],
            ['', 'fooBar', 'fooBar'],

            ['jane', 'foo', 'jane.foo'],
            ['jane', 'fooBar', 'jane.fooBar'],
        ];
    }

    /**
     * @test
     * @dataProvider provideCanGenerateFieldName
     *
     * @group unit
     * @group core
     * @group filter
     *
     * @param string|string $prefix
     * @param string $column
     * @param string $expected
     */
    public function canGenerateFieldName(?string $prefix, string $column, string $expected): void
    {
        $output = FilterDatabaseHelper::generateFieldName($prefix, $column);
        self::assertEquals($expected, $output);
    }

    /**
     * Data provider.
     *
     * @return array
     */
    public function provideCanGetAliasFromColumn(): array
    {
        return [
            ['foo.bar', 'foo'],
            ['fooBar.foo', 'fooBar'],
        ];
    }

    /**
     * @test
     * @dataProvider provideCanGetAliasFromColumn
     *
     * @group unit
     * @group core
     * @group filter
     *
     * @param string $column
     * @param string $expected
     */
    public function canGetAliasFromColumn(string $column, string $expected): void
    {
        $output = FilterDatabaseHelper::getAliasFromColumn($column);
        self::assertEquals($expected, $output);
    }
}
