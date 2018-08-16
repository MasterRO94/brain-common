<?php

declare(strict_types=1);

namespace Brain\Common\Dimension;

use Brain\Common\Dimension\Column\DepthDimensionInterface;
use Brain\Common\Dimension\Column\HeightDimensionInterface;
use Brain\Common\Dimension\Column\WidthDimensionInterface;

/**
 * Representing a three dimensional object.
 *
 * Our standard three dimensional object contains width, height and depth dimensions.
 * An example of this could be a box or package in 3D space.
 */
interface ThreeDimensionalInterface extends
    DimensionInterface,
    WidthDimensionInterface,
    HeightDimensionInterface,
    DepthDimensionInterface
{
}
