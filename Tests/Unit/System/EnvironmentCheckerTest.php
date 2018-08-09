<?php

declare(strict_types=1);

namespace Brain\Common\Tests\Unit\System;

use Brain\Common\System\EnvironmentChecker;

use PHPUnit\Framework\TestCase;

final class EnvironmentCheckerTest extends TestCase
{
    /**
     * Data provider.
     *
     * @return string[][]|bool[][]
     */
    public function productionDataProvider(): array
    {
        return [
            ['production', true],
            ['live', false],
            ['testing', false],
            ['staging', false],
        ];
    }

    /**
     * @dataProvider productionDataProvider
     */
    public function testIsProductionEnvironmentStrings(string $environment, bool $value): void
    {
        $environmentChecker = new EnvironmentChecker($environment);

        self::assertSame($environmentChecker->isProduction(), $value);
    }

    /**
     * Data provider.
     *
     * @return string[][]|bool[][]
     */
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
     * @dataProvider nonProductionDataProvider
     */
    public function testIsNonProductionEnvironmentStrings(string $environment, bool $value): void
    {
        $environmentChecker = new EnvironmentChecker($environment);

        self::assertSame($environmentChecker->isNonProduction(), $value);
    }
}
