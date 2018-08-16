<?php

declare(strict_types=1);

namespace Brain\Common\Dimension\Range;

use Brain\Common\Dimension\TwoDimensionalInterface;

/**
 * {@inheritdoc}
 */
final class TwoDimensionalRange implements TwoDimensionalRangeInterface
{
    private $minimum;
    private $maximum;

    public function __construct(TwoDimensionalInterface $minimum, TwoDimensionalInterface $maximum)
    {
        $this->minimum = $minimum;
        $this->maximum = $maximum;
    }

    /**
     * {@inheritdoc}
     *
     * @return TwoDimensionalInterface
     */
    public function getMinimumDimension(): TwoDimensionalInterface
    {
        return $this->minimum;
    }

    /**
     * {@inheritdoc}
     *
     * @return TwoDimensionalInterface
     */
    public function getMaximumDimension(): TwoDimensionalInterface
    {
        return $this->maximum;
    }
}
