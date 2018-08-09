<?php

declare(strict_types=1);

namespace Brain\Common\Debug;

use Symfony\Component\Stopwatch\StopwatchEvent;

/**
 * A null stopwatch that will never do anything. Ever.
 *
 * {@inheritdoc}
 */
final class NullStopwatch implements StopwatchInterface
{
    /**
     * {@inheritdoc}
     */
    public function start(string $name, ?string $category = null): ?StopwatchEvent
    {
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function stop(string $name): ?StopwatchEvent
    {
        return null;
    }
}
