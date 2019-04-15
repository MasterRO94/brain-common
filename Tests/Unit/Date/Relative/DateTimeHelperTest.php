<?php

declare(strict_types=1);

namespace Brain\Common\Tests\Unit\Date\Relative;

use Brain\Common\Date\Relative\DateTimeRelativeHelper;

use DateTime;
use PHPUnit\Framework\TestCase;

/**
 * {@inheritdoc}
 *
 * @group unit
 * @group date
 *
 * @covers \Brain\Common\Date\Relative\DateTimeRelativeHelper
 */
final class DateTimeHelperTest extends TestCase
{
    /**
     * Date provider.
     *
     * @return string[][]
     */
    public function provideCanCreateRelativeDate(): array
    {
        return [
            'now' => ['2018-06-05', 'now'],
            'today' => ['2018-06-05', 'today'],
            'tomorrow' => ['2018-06-06', 'tomorrow'],
            'yesterday' => ['2018-06-04', 'yesterday'],

            'add-2-days' => ['2018-06-07', '+2 days'],
            'add-week' => ['2018-06-12', '+1 week'],

            'minus-2-days' => ['2018-06-03', '-2 days'],
            'minus-week' => ['2018-05-29', '-1 week'],

            'month-day-first' => ['2018-06-01', 'first day of this month'],
            'month-day-last' => ['2018-06-30', 'last day of this month'],

            // These are expected as its a gotcha from PHP.
            'php-week-day-first' => ['2018-05-01', 'first day of this week'],
            'php-week-day-last' => ['2018-06-30', 'last day of this week'],

            // Pretty sure this is a fluke, as working from this date is weird.
            'php-month-day-first' => ['2018-06-01', 'first day of this month'],
            'php-month-day-last' => ['2018-06-30', 'last day of this month'],

            // This is what I mean by fluke, PHP doesn't know what its doing with these terms.
            'php-year-day-first' => ['2018-06-01', 'first day of this year'],
            'php-year-day-last' => ['2018-06-30', 'last day of this year'],

            // This is how you actually get to the first day of the week.
            'week-day-first' => ['2018-06-04', 'this week'],
            'week-day-last' => ['2018-06-10', 'next week -1 day'],

            // This is the proper day in year syntax ..
            'year-day-first' => ['2018-01-01', 'first day of january this year'],
            'year-day-last' => ['2018-12-31', 'last day of december this year'],

            // Constant testing ..
            'const-week-this-day-first' => ['2018-06-04', DateTimeRelativeHelper::RELATIVE_WEEK_THIS_DAY_FIRST],
            'const-week-this-day-last' => ['2018-06-10', DateTimeRelativeHelper::RELATIVE_WEEK_THIS_DAY_LAST],
            'const-week-next-day-first' => ['2018-06-11', DateTimeRelativeHelper::RELATIVE_WEEK_NEXT_DAY_FIRST],
            'const-week-next-day-last' => ['2018-06-17', DateTimeRelativeHelper::RELATIVE_WEEK_NEXT_DAY_LAST],
            'const-week-previous-day-first' => ['2018-05-28', DateTimeRelativeHelper::RELATIVE_WEEK_PREVIOUS_DAY_FIRST],
            'const-week-previous-day-last' => ['2018-06-03', DateTimeRelativeHelper::RELATIVE_WEEK_PREVIOUS_DAY_LAST],

            'const-month-this-day-first' => ['2018-06-01', DateTimeRelativeHelper::RELATIVE_MONTH_THIS_DAY_FIRST],
            'const-month-this-day-last' => ['2018-06-30', DateTimeRelativeHelper::RELATIVE_MONTH_THIS_DAY_LAST],
            'const-month-next-day-first' => ['2018-07-01', DateTimeRelativeHelper::RELATIVE_MONTH_NEXT_DAY_FIRST],
            'const-month-next-day-last' => ['2018-07-31', DateTimeRelativeHelper::RELATIVE_MONTH_NEXT_DAY_LAST],
            'const-month-previous-day-first' => ['2018-05-01', DateTimeRelativeHelper::RELATIVE_MONTH_PREVIOUS_DAY_FIRST],
            'const-month-previous-day-last' => ['2018-05-31', DateTimeRelativeHelper::RELATIVE_MONTH_PREVIOUS_DAY_LAST],

            'const-year-this-day-first' => ['2018-01-01', DateTimeRelativeHelper::RELATIVE_YEAR_THIS_DAY_FIRST],
            'const-year-this-day-last' => ['2018-12-31', DateTimeRelativeHelper::RELATIVE_YEAR_THIS_DAY_LAST],
            'const-year-next-day-first' => ['2019-01-01', DateTimeRelativeHelper::RELATIVE_YEAR_NEXT_DAY_FIRST],
            'const-year-next-day-last' => ['2019-12-31', DateTimeRelativeHelper::RELATIVE_YEAR_NEXT_DAY_LAST],
            'const-year-previous-day-first' => ['2017-01-01', DateTimeRelativeHelper::RELATIVE_YEAR_PREVIOUS_DAY_FIRST],
            'const-year-previous-day-last' => ['2017-12-31', DateTimeRelativeHelper::RELATIVE_YEAR_PREVIOUS_DAY_LAST],
        ];
    }

    /**
     * @test
     * @dataProvider provideCanCreateRelativeDate
     */
    public function canCreateRelativeDate(string $expected, string $input): void
    {
        $base = new DateTime('2018-06-05');
        $response = DateTimeRelativeHelper::createRelativeDate($input, $base);

        self::assertEquals($expected, $response->format('Y-m-d'));
    }
}
