<?php

declare(strict_types=1);

namespace Brain\Common\Debug;

use Symfony\Component\Stopwatch\Stopwatch as SymfonyStopwatch;
use Symfony\Component\Stopwatch\StopwatchEvent;

/**
 * {@inheritdoc}
 *
 * This service is safe to use in all environments because the methods will do nothing when
 * the symfony stopwatch service is not present.
 */
final class Stopwatch implements StopwatchInterface
{
    /** @var SymfonyStopwatch|null */
    private $stopwatch;

    public function __construct(?SymfonyStopwatch $stopwatch = null)
    {
        $this->stopwatch = $stopwatch;
    }

    /**
     * {@inheritdoc}
     */
    public function start(string $name, ?string $category = null): ?StopwatchEvent
    {
        if (!$this->stopwatch instanceof SymfonyStopwatch) {
            return null;
        }

        return $this->stopwatch->start($name, $category);
    }

    /**
     * {@inheritdoc}
     */
    public function stop(string $name): ?StopwatchEvent
    {
        if (!$this->stopwatch instanceof SymfonyStopwatch) {
            return null;
        }

        return $this->stopwatch->stop($name);
    }
}
