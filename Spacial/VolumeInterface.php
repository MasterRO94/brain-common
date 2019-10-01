<?php

declare(strict_types=1);

namespace Brain\Common\Spacial;

use Brain\Common\Dimension\ThreeDimensionalInterface;
use Brain\Common\Representation\Type\IntegerRepresentationInterface;

/**
 * A representation of volume.
 */
interface VolumeInterface extends
    IntegerRepresentationInterface
{
    /**
     * Check this volume is within the given volume.
     */
    public function isLessThanOrEqual(VolumeInterface $volume): bool;

    /**
     * Check the volume is within the three dimensions volume.
     */
    public function isLessThanOrEqualToThreeDimensional(ThreeDimensionalInterface $dimension): bool;
}
