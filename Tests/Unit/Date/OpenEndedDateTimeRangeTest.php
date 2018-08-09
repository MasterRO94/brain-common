<?php

declare(strict_types=1);

namespace Brain\Common\Tests\Unit\Date;

use Brain\Common\Date\Range\OpenEndedDateTimeRange;

use DateTime;
use PHPUnit\Framework\TestCase;

/**
 * {@inheritdoc}
 */
final class OpenEndedDateTimeRangeTest extends TestCase
{
    /**
     * @test
     *
     * @group unit
     * @group date
     *
     * @covers \Brain\Common\Date\Range\OpenEndedDateTimeRange
     */
    public function checkBasicUsageSameAsDateTimeRange(): void
    {
        $from = new DateTime('2010-01-01 00:00:00');
        $to = new DateTime('2020-02-02 00:00:00');

        $range = new OpenEndedDateTimeRange($from, $to);

        self::assertSame($from, $range->getFrom());
        self::assertSame($to, $range->getTo());
    }

    /**
     * @test
     *
     * @group unit
     * @group date
     *
     * @covers \Brain\Common\Date\Range\OpenEndedDateTimeRange
     */
    public function canCreateOpenEndedFromDate(): void
    {
        $from = new DateTime('2010-01-01 00:00:00');

        $range = OpenEndedDateTimeRange::createFrom($from);

        $to = new DateTime('3000-01-01 00:00:00');

        self::assertFalse($range->isFromOpenEnded());
        self::assertTrue($range->isToOpenEnded());

        self::assertSame($from, $range->getFrom());
        self::assertEquals($to->format('c'), $range->getTo()->format('c'));
    }

    /**
     * @test
     *
     * @group unit
     * @group date
     *
     * @covers \Brain\Common\Date\Range\OpenEndedDateTimeRange
     */
    public function canCreateOpenEndedUntilDate(): void
    {
        $to = new DateTime('2010-01-01 00:00:00');

        $range = OpenEndedDateTimeRange::createTo($to);

        $from = new DateTime('1000-01-01 00:00:00');

        self::assertTrue($range->isFromOpenEnded());
        self::assertFalse($range->isToOpenEnded());

        self::assertSame($to, $range->getTo());
        self::assertEquals($from->format('c'), $range->getFrom()->format('c'));
    }
}
