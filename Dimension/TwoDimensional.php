<?php

declare(strict_types=1);

namespace Brain\Common\Dimension;

use Brain\Common\Debug\Representation\DebugRepresentationInterface;
use Brain\Common\Debug\Representation\DebugRepresentationTrait;
use Brain\Common\Spacial\Area;
use Brain\Common\Spacial\AreaInterface;

/**
 * {@inheritdoc}
 */
final class TwoDimensional implements
    TwoDimensionalInterface,
    DebugRepresentationInterface
{
    use DebugRepresentationTrait;

    /** @var int */
    private $width;

    /** @var int */
    private $height;

    /**
     * Return a zero'd two dimensional.
     *
     * @return TwoDimensional
     */
    public static function createZero(): self
    {
        return new self(0, 0);
    }

    public function __construct(int $width, int $height)
    {
        $this->width = $width;
        $this->height = $height;
    }

    /**
     * {@inheritdoc}
     */
    public function getWidth(): int
    {
        return $this->width;
    }

    /**
     * {@inheritdoc}
     */
    public function getHeight(): int
    {
        return $this->height;
    }

    /**
     * {@inheritdoc}
     */
    public function getArea(): AreaInterface
    {
        return Area::createFromTwoDimensional($this);
    }

    /**
     * {@inheritdoc}
     */
    public function isSquare(): bool
    {
        // Nothing is not square, its nothing.
        if ($this->width === 0 && $this->height === 0) {
            return false;
        }

        return $this->width === $this->height;
    }

    /**
     * {@inheritdoc}
     */
    public function toString(): string
    {
        return sprintf('%sx%s', $this->width, $this->height);
    }

    /**
     * {@inheritdoc}
     */
    public function toArray(): array
    {
        return [
            'width' => $this->getWidth(),
            'height' => $this->getHeight(),
        ];
    }
}
