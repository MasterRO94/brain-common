<?php

declare(strict_types=1);

namespace Brain\Common\Spacial;

use Brain\Common\Dimension\ThreeDimensionalInterface;

/**
 * A representation of volume.
 */
final class Volume implements VolumeInterface
{
    /** @var int */
    private $value;

    /**
     * Create a zero volume instance.
     *
     * @return Volume
     */
    public static function createZero(): self
    {
        return new self(0);
    }

    /**
     * Create an volume from three dimensional.
     *
     * @return Volume
     */
    public static function createFromThreeDimensional(ThreeDimensionalInterface $dimensional): self
    {
        $area = $dimensional->getArea()->toInteger();

        return new self($area * $dimensional->getDepth());
    }

    public function __construct(int $value)
    {
        $this->value = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function isLessThanOrEqual(VolumeInterface $volume): bool
    {
        return $this->value <= $volume->toInteger();
    }

    /**
     * {@inheritdoc}
     */
    public function isLessThanOrEqualToThreeDimensional(ThreeDimensionalInterface $dimension): bool
    {
        return $this->isLessThanOrEqual($dimension->getVolume());
    }

    /**
     * {@inheritdoc}
     */
    public function toInteger(): int
    {
        return $this->value;
    }
}
