<?php

declare(strict_types=1);

namespace Brain\Common\Dimension;

use Brain\Common\Dimension\Column\HeightDimensionInterface;
use Brain\Common\Dimension\Column\WidthDimensionInterface;
use Brain\Common\Representation\Type\ArrayRepresentationInterface;
use Brain\Common\Representation\Type\StringRepresentationInterface;

/**
 * Representing a two dimensional object.
 *
 * Our standard two dimensional object contains a width and height.
 * An example being a sheet or paper size in 2D space.
 */
interface TwoDimensionalInterface extends
    DimensionInterface,
    WidthDimensionInterface,
    HeightDimensionInterface,
    StringRepresentationInterface,
    ArrayRepresentationInterface
{
    /**
     * Check this object can be considered a square in two dimensional terms.
     */
    public function isSquare(): bool;
}
