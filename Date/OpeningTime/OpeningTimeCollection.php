<?php

declare(strict_types=1);

namespace Brain\Common\Date\OpeningTime;

use Brain\Common\Date\Enum\WeekdayEnum;
use Brain\Common\Date\Time\Time;

/**
 * A collection of opening times.
 */
final class OpeningTimeCollection
{
    /** @var int[] */
    private $weekdays = [];

    /** @var OpeningTimeInterface[] */
    private $collection = [];

    /**
     * @param OpeningTimeInterface[] $openings
     */
    public function __construct(array $openings)
    {
        foreach ($openings as $opening) {
            $this->add($opening);
        }
    }

    /**
     * Add in opening time to the collection.
     */
    private function add(OpeningTimeInterface $opening): void
    {
        $value = $opening->getWeekday()->value();

        if (in_array($value, $this->weekdays, true) === false) {
            $this->weekdays[] = $value;
        }

        $this->collection[] = $opening;
    }

    public function isOpen(WeekdayEnum $weekday, Time $time): bool
    {
        if ($this->isWeekdayOpen($weekday) === false) {
            return false;
        }

        foreach ($this->collection as $opening) {
            if ($opening->isWeekdayOpen($weekday) === false) {
                continue;
            }

            if ($opening->isTimeOpen($time) === true) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if the weekday is open.
     */
    public function isWeekdayOpen(WeekdayEnum $weekday): bool
    {
        $value = $weekday->value();

        return in_array($value, $this->weekdays, true);
    }
}
