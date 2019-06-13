<?php

declare(strict_types=1);

namespace Brain\Common\Regex;

/**
 * A simple regex helper for matching strings.
 */
final class RegexMatch
{
    /**
     * Validate a string matches the given regex.
     */
    public static function match(string $regex, string $value): bool
    {
        return preg_match($regex, $value) === 1;
    }
}
