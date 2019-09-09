<?php

declare(strict_types=1);

namespace Brain\Common\Checksum;

use Brain\Common\Regex\RegexMatch;

/**
 * A regex helper for checksum's.
 */
final class ChecksumRegex
{
    public const REGEX_MD5 = '^[a-f0-9]{32}$';
    public const REGEX_SHA1 = '^[a-f0-9]{40}$';
    public const REGEX_SHA256 = '^[a-f0-9]{64}$';

    /**
     * Check the value given is a MD5.
     */
    public static function isMD5(string $value): bool
    {
        return RegexMatch::match(self::build(self::REGEX_MD5), $value);
    }

    /**
     * Check the value given is a SHA1.
     */
    public static function isSHA1(string $value): bool
    {
        return RegexMatch::match(self::build(self::REGEX_SHA1), $value);
    }

    /**
     * Check the value given is a SHA256.
     */
    public static function isSHA256(string $value): bool
    {
        return RegexMatch::match(self::build(self::REGEX_SHA256), $value);
    }

    /**
     * Build a case-insensitive regular expression.
     */
    private static function build(string $regex): string
    {
        return sprintf('/%s/i', $regex);
    }
}
