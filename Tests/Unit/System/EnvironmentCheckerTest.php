<?php

namespace Brain\Common\Tests\Unit\System;

use Brain\Common\System\EnvironmentChecker;

use PHPUnit\Framework\TestCase;

final class EnvironmentCheckerTest extends TestCase
{
    public function productionDataProvider(): array
    {
        return [
            ['production', true],
            ['live', false],
            ['testing', false],
            ['staging', false],
        ];
    }

    public function nonProductionDataProvider(): array
    {
        return [
            ['production', false],
            ['live', true],
            ['testing', true],
            ['staging', true],
        ];
    }

    /**
     * @dataProvider productionDataProvider
     *
     * @param string $environment
     * @param bool $value
     */
    public function testIsProductionEnvironmentStrings(string $environment, bool $value)
    {
        $environmentChecker = new EnvironmentChecker($environment);

        self::assertSame($environmentChecker->isProduction(), $value);
    }

    /**
     * @dataProvider nonProductionDataProvider
     *
     * @param string $environment
     * @param bool $value
     */
    public function testIsNonProductionEnvironmentStrings(string $environment, bool $value)
    {
        $environmentChecker = new EnvironmentChecker($environment);

        self::assertSame($environmentChecker->isNonProduction(), $value);
    }
}