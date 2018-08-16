<?php

declare(strict_types=1);

namespace Brain\Common\Dimension;

use Brain\Common\Dimension\Column\HeightDimensionInterface;
use Brain\Common\Dimension\Column\WidthDimensionInterface;

/**
 * Representing a two dimensional object.
 *
 * Our standard two dimensional object contains a width and height.
 * An example being a sheet or paper size in 2D space.
 */
interface TwoDimensionalInterface extends
    DimensionInterface,
    WidthDimensionInterface,
    HeightDimensionInterface
{
    /**
     * Return the square.
     */
    public function isSquare(): bool;
}
