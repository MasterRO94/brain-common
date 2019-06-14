<?php

declare(strict_types=1);

namespace Brain\Common\Tests\Unit\Date\Enum;

use Brain\Common\Date\Enum\WeekdayEnum;

use DateTime;
use PHPUnit\Framework\TestCase;

/**
 * @group common
 * @group unit
 * @group date
 *
 * @covers \Brain\Common\Date\Enum\WeekdayEnum
 */
final class WeekdayEnumTest extends TestCase
{
    /**
     * @test
     */
    public function canCreateFromDateTimeInterface(): void
    {
        $date = new DateTime('2019-01-01');

        $weekday = WeekdayEnum::createFromDateTimeInterface($date);

        self::assertEquals(WeekdayEnum::DAY_TUESDAY, $weekday->value());
        self::assertEquals('tuesday', $weekday->translation(false));
        self::assertEquals('weekday.tuesday', $weekday->translation(true));
    }
}
