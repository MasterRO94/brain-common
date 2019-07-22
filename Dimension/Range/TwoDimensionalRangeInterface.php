<?php

declare(strict_types=1);

namespace Brain\Common\Dimension\Range;

use Brain\Common\Dimension\TwoDimensionalInterface;
use Brain\Common\Representation\Type\ArrayRepresentationInterface;
use Brain\Common\Representation\Type\StringRepresentationInterface;

/**
 * Representing a dimensional range in two dimensions.
 *
 * Essentially a minimum and maximum width and height.
 */
interface TwoDimensionalRangeInterface extends
    StringRepresentationInterface,
    ArrayRepresentationInterface
{
    /**
     * Return the minimum dimensional range.
     */
    public function getMinimumDimension(): TwoDimensionalInterface;

    /**
     * Return the maximum dimensional range.
     */
    public function getMaximumDimension(): TwoDimensionalInterface;
}
