<?php

declare(strict_types=1);

namespace Brain\Common\Dimension;

use JMS\Serializer\Annotation as Serializer;

/**
 * @Serializer\ExclusionPolicy("ALL")
 * @Serializer\AccessorOrder(
 *   order="custom",
 *   custom={
 *     "width",
 *     "height"
 *   }
 * )
 */
final class ThreeDimensional implements ThreeDimensionalInterface
{
    /**
     * @var int
     *
     * @Serializer\Expose()
     * @Serializer\Groups({"global"})
     */
    protected $width;

    /**
     * @var int
     *
     * @Serializer\Expose()
     * @Serializer\Groups({"global"})
     */
    protected $height;

    /**
     * @var int
     *
     * @Serializer\Expose()
     * @Serializer\Groups({"global"})
     */
    protected $depth;

    /**
     * {@inheritdoc}
     *
     * @param int $width
     * @param int $height
     * @param int $depth
     */
    public function __construct(int $width, int $height, int $depth)
    {
        $this->width = $width;
        $this->height = $height;
        $this->depth = $depth;
    }

    /**
     * Return the width in millimeters (mm).
     */
    public function getWidth(): int
    {
        return $this->width;
    }

    /**
     * Return the height in millimeters (mm).
     */
    public function getHeight(): int
    {
        return $this->height;
    }

    /**
     * Return the depth in millimeters (mm).
     */
    public function getDepth(): int
    {
        return $this->depth;
    }
}
