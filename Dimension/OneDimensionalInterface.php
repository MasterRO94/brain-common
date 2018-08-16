<?php

declare(strict_types=1);

namespace Brain\Common\Dimension;

use Brain\Common\Dimension\Column\WidthDimensionInterface;

/**
 * Representing a single dimensional object.
 *
 * Our standard single dimensional object contains a width dimension only.
 * An example of this is an abstract line.
 */
interface OneDimensionalInterface extends DimensionInterface, WidthDimensionInterface
{
}
