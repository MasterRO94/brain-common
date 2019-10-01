<?php

declare(strict_types=1);

namespace Brain\Common\Dimension;

use Brain\Common\Dimension\Column\DepthDimensionInterface;
use Brain\Common\Spacial\VolumeInterface;

/**
 * Representing a three dimensional object.
 *
 * Our standard three dimensional object contains width, height and depth dimensions.
 * An example of this could be a box or package in 3D space.
 */
interface ThreeDimensionalInterface extends
    TwoDimensionalInterface,
    DepthDimensionInterface
{
    /**
     * Return the volume of the three dimensional.
     */
    public function getVolume(): VolumeInterface;

    /**
     * Check this object can be considered a cube in three dimensional terms.
     */
    public function isCube(): bool;
}
