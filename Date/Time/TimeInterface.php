<?php

declare(strict_types=1);

namespace Brain\Common\Date\Time;

use Brain\Common\Representation\Type\IntegerRepresentationInterface;
use Brain\Common\Representation\Type\StringRepresentationInterface;

/**
 * An instance of time.
 */
interface TimeInterface extends
    StringRepresentationInterface,
    IntegerRepresentationInterface
{
    /**
     * Return the hour.
     */
    public function getHour(): int;

    /**
     * Return the minute.
     */
    public function getMinute(): int;

    /**
     * Return the second.
     */
    public function getSecond(): int;

    /**
     * Check if this instance if greater than or equal to the given time.
     */
    public function isGreaterThanOrEqual(TimeInterface $time): bool;

    /**
     * Check if this instance is equal to the given time.
     */
    public function isEqual(TimeInterface $time): bool;

    /**
     * Check if this instance is greater than the given time.
     */
    public function isGreaterThan(TimeInterface $time): bool;

    /**
     * Check if this instance if less than or equal to the given time.
     */
    public function isLessThanOrEqual(TimeInterface $time): bool;

    /**
     * Check if this instance is less than the given time.
     */
    public function isLessThan(TimeInterface $time): bool;
}
