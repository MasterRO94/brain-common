<?php

declare(strict_types=1);

namespace Brain\Common\Date\Relative;

interface DateTimeRelativeFormatInterface
{
    /**
     * Relative days of THIS week.
     *
     * Note that this depends on date settings in PHP, the first day of the week appears to be
     * a Monday and is most likely configured through INI.
     */
    public const RELATIVE_WEEK_THIS_DAY_FIRST = 'this week';
    public const RELATIVE_WEEK_THIS_DAY_LAST = 'next week -1 day';

    /**
     * Relative days of NEXT week.
     *
     * Note that this depends on date settings in PHP, the first day of the week appears to be
     * a Monday and is most likely configured through INI.
     */
    public const RELATIVE_WEEK_NEXT_DAY_FIRST = 'next week';
    public const RELATIVE_WEEK_NEXT_DAY_LAST = 'next week +1 week -1 day';

    /**
     * Relative days of the PREVIOUS week.
     *
     * Note that this depends on date settings in PHP, the first day of the week appears to be
     * a Monday and is most likely configured through INI.
     */
    public const RELATIVE_WEEK_PREVIOUS_DAY_FIRST = 'last week';
    public const RELATIVE_WEEK_PREVIOUS_DAY_LAST = 'this week -1 day';

    /**
     * Relative days of months, THIS month.
     */
    public const RELATIVE_MONTH_THIS_DAY_FIRST = 'first day of this month';
    public const RELATIVE_MONTH_THIS_DAY_LAST = 'last day of this month';

    /**
     * Relative days of months, NEXT month.
     */
    public const RELATIVE_MONTH_NEXT_DAY_FIRST = 'first day of next month';
    public const RELATIVE_MONTH_NEXT_DAY_LAST = 'last day of next month';

    /**
     * Relative days of months, PREVIOUS month.
     */
    public const RELATIVE_MONTH_PREVIOUS_DAY_FIRST = 'first day of last month';
    public const RELATIVE_MONTH_PREVIOUS_DAY_LAST = 'last day of this month -1 month';

    /**
     * Relative days of year, THIS year.
     */
    public const RELATIVE_YEAR_THIS_DAY_FIRST = 'first day of january this year';
    public const RELATIVE_YEAR_THIS_DAY_LAST = 'last day of december this year';

    /**
     * Relative days of year, NEXT year.
     */
    public const RELATIVE_YEAR_NEXT_DAY_FIRST = 'first day of january next year';
    public const RELATIVE_YEAR_NEXT_DAY_LAST = 'next year last day of december';

    /**
     * Relative days of year, PREVIOUS year.
     */
    public const RELATIVE_YEAR_PREVIOUS_DAY_FIRST = 'first day of january last year';
    public const RELATIVE_YEAR_PREVIOUS_DAY_LAST = 'last day of december last year';
}
