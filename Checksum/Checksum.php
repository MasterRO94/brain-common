<?php

declare(strict_types=1);

namespace Brain\Common\Checksum;

/**
 * A checksum.
 *
 * To implement more make use of composition and the interface.
 * Internally construct this and make the methods use this, add your own factories on that.
 * Or provide a PR to the code base and add it here.
 */
final class Checksum implements
    ChecksumInterface
{
    /** @var string */
    private $format;

    /** @var string */
    private $value;

    public function __construct(string $format, string $value)
    {
        $this->format = $format;
        $this->value = strtolower($value);
    }

    /**
     * {@inheritdoc}
     */
    public function format(): string
    {
        return $this->format;
    }

    /**
     * {@inheritdoc}
     */
    public function toString(): string
    {
        return $this->value;
    }
}
