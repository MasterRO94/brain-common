<?php

declare(strict_types=1);

namespace Brain\Common\Checksum\Format;

use Brain\Common\Checksum\Checksum;
use Brain\Common\Checksum\ChecksumInterface;
use Brain\Common\Checksum\ChecksumRegex;
use Brain\Common\Checksum\Exception\ChecksumInvalidForFormatException;

/**
 * A checksum from the SHA series.
 */
final class ShaChecksum implements
    ChecksumInterface
{
    public const FORMAT_SHA1 = 'sha1';
    public const FORMAT_SHA256 = 'sha256';

    /** @var Checksum */
    private $checksum;

    /**
     * @throws ChecksumInvalidForFormatException
     */
    public static function sha1(string $value, bool $hashed): ShaChecksum
    {
        if ($hashed === false) {
            $value = hash('sha1', $value);
        } elseif (ChecksumRegex::isSHA1($value) === false) {
            throw ChecksumInvalidForFormatException::create(self::FORMAT_SHA1, $value);
        }

        return new self(new Checksum(self::FORMAT_SHA1, $value));
    }

    /**
     * @throws ChecksumInvalidForFormatException
     */
    public static function sha256(string $value, bool $hashed): ShaChecksum
    {
        if ($hashed === false) {
            $value = hash('sha256', $value);
        } elseif (ChecksumRegex::isSHA256($value) === false) {
            throw ChecksumInvalidForFormatException::create(self::FORMAT_SHA256, $value);
        }

        return new self(new Checksum(self::FORMAT_SHA256, $value));
    }

    public function __construct(Checksum $checksum)
    {
        $this->checksum = $checksum;
    }

    /**
     * {@inheritdoc}
     */
    public function format(): string
    {
        return $this->checksum->format();
    }

    /**
     * {@inheritdoc}
     */
    public function toString(): string
    {
        return $this->checksum->toString();
    }
}
