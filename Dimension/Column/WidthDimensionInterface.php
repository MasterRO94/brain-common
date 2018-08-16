<?php

declare(strict_types=1);

namespace Brain\Common\Dimension\Column;

/**
 * An interface defining a way to get a width measurement.
 */
interface WidthDimensionInterface
{
    /**
     * Return the width in millimeters (mm).
     */
    public function getWidth(): int;
}
