<?php

declare(strict_types=1);

namespace Brain\Common\Form\Model\Dimension\Range;

use Brain\Common\Dimension\Range\TwoDimensionalRangeInterface;
use Brain\Common\Dimension\TwoDimensionalInterface;

/**
 * {@inheritdoc}
 *
 * @internal
 */
final class TwoDimensionalRangeFormModel implements TwoDimensionalRangeInterface
{
    /** @var TwoDimensionalInterface */
    public $minimum;

    /** @var TwoDimensionalInterface */
    public $maximum;

    /**
     * {@inheritdoc}
     */
    public function getMinimumDimension(): TwoDimensionalInterface
    {
        return $this->minimum;
    }

    /**
     * {@inheritdoc}
     */
    public function getMaximumDimension(): TwoDimensionalInterface
    {
        return $this->maximum;
    }
}
