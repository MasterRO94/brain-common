<?php

namespace Brain\Common\Debug;

use Symfony\Component\Stopwatch\StopwatchEvent;

/**
 * A wrapper for stopwatch that allows it to be used consistently in production.
 */
interface StopwatchInterface
{
    /**
     * Start the stopwatch.
     *
     * @param string $name
     * @param string|null $category
     *
     * @return StopwatchEvent|null
     */
    public function start(string $name, string $category = null): ?StopwatchEvent;

    /**
     * Stop the stopwatch.
     *
     * @param string $name
     *
     * @return StopwatchEvent|null
     */
    public function stop(string $name): ?StopwatchEvent;
}
