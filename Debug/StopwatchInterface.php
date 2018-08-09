<?php

declare(strict_types=1);

namespace Brain\Common\Debug;

use Symfony\Component\Stopwatch\StopwatchEvent;

/**
 * A wrapper for stopwatch that allows it to be used consistently in production.
 */
interface StopwatchInterface
{
    /**
     * Start the stopwatch.
     */
    public function start(string $name, ?string $category = null): ?StopwatchEvent;

    /**
     * Stop the stopwatch.
     */
    public function stop(string $name): ?StopwatchEvent;
}
