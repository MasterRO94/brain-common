<?php

declare(strict_types=1);

namespace Brain\Common\Tests\Unit\Date;

use Brain\Common\Date\Range\DateTimeRange;

use DateTime;
use PHPUnit\Framework\TestCase;

/**
 * {@inheritdoc}
 */
final class DateTimeRangeTest extends TestCase
{
    /**
     * @test
     *
     * @group unit
     * @group date
     *
     * @covers \Brain\Common\Date\Range\DateTimeRange
     */
    public function checkBasicUsage(): void
    {
        $from = new DateTime('2010-01-01 00:00:00');
        $to = new DateTime('2020-02-02 00:00:00');

        $range = new DateTimeRange($from, $to);

        self::assertSame($from, $range->getFrom());
        self::assertSame($to, $range->getTo());
    }
}
