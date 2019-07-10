<?php

declare(strict_types=1);

namespace Brain\Common\Dimension\Range;

use Brain\Common\Debug\Representation\DebugRepresentationInterface;
use Brain\Common\Debug\Representation\DebugRepresentationTrait;
use Brain\Common\Dimension\TwoDimensionalInterface;

/**
 * {@inheritdoc}
 */
final class TwoDimensionalRange implements
    TwoDimensionalRangeInterface,
    DebugRepresentationInterface
{
    use DebugRepresentationTrait;

    /** @var TwoDimensionalInterface */
    private $minimum;

    /** @var TwoDimensionalInterface */
    private $maximum;

    public function __construct(TwoDimensionalInterface $minimum, TwoDimensionalInterface $maximum)
    {
        $this->minimum = $minimum;
        $this->maximum = $maximum;
    }

    /**
     * {@inheritdoc}
     *
     * @return TwoDimensionalInterface
     */
    public function getMinimumDimension(): TwoDimensionalInterface
    {
        return $this->minimum;
    }

    /**
     * {@inheritdoc}
     *
     * @return TwoDimensionalInterface
     */
    public function getMaximumDimension(): TwoDimensionalInterface
    {
        return $this->maximum;
    }

    /**
     * {@inheritdoc}
     */
    public function toString(): string
    {
        return sprintf('%s-%s', $this->minimum->toString(), $this->maximum->toString());
    }

    /**
     * {@inheritdoc}
     */
    public function toArray(): array
    {
        return [
            'minimum' => $this->minimum->toArray(),
            'maximum' => $this->maximum->toArray(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function toDebugParameters(): array
    {
        return [
            'minimum' => $this->minimum,
            'maximum' => $this->maximum,
        ];
    }
}
