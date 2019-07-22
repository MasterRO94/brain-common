<?php

declare(strict_types=1);

namespace Brain\Common\Form\Model\Dimension\Range;

use Brain\Common\Debug\Representation\DebugRepresentation;
use Brain\Common\Debug\Representation\DebugRepresentationInterface;
use Brain\Common\Debug\Representation\DebugRepresentationTrait;
use Brain\Common\Dimension\Range\TwoDimensionalRangeInterface;
use Brain\Common\Dimension\TwoDimensionalInterface;

/**
 * @internal
 */
final class TwoDimensionalRangeFormModel implements
    TwoDimensionalRangeInterface,
    DebugRepresentationInterface
{
    use DebugRepresentationTrait;

    /** @var TwoDimensionalInterface */
    public $minimum;

    /** @var TwoDimensionalInterface */
    public $maximum;

    /**
     * {@inheritdoc}
     */
    public function getMinimumDimension(): TwoDimensionalInterface
    {
        return $this->minimum;
    }

    /**
     * {@inheritdoc}
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
        return sprintf('%sx%s', $this->minimum->toString(), $this->maximum->toString());
    }

    /**
     * {@inheritdoc}
     */
    public function toArray(): array
    {
        return [
            'minimum' => DebugRepresentation::attempt($this->minimum),
            'maximum' => DebugRepresentation::attempt($this->maximum),
        ];
    }
}
