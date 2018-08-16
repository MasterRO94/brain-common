<?php

declare(strict_types=1);

namespace Brain\Common\Dimension\Column;

/**
 * An interface defining a way to get a height measurement.
 */
interface HeightDimensionInterface
{
    /**
     * Return the height in millimeters (mm).
     */
    public function getHeight(): int;
}
