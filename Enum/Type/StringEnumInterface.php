<?php

declare(strict_types=1);

namespace Brain\Common\Enum\Type;

use Brain\Common\Enum\EnumInterface;

/**
 * A string enum.
 *
 * Used to enforce strict typing on the overridden methods.
 * This can probably be fixed up a bit with PHP 7.4 covariance/contra-variance changes.
 */
interface StringEnumInterface extends
    EnumInterface
{
    /**
     * Return all values within the enum.
     *
     * @return string[]
     */
    public static function all(bool $sort = false): array;

    /**
     * Check if the enum has the value.
     *
     * @param string $value
     */
    public static function has($value): bool;

    /**
     * Return the enum value.
     */
    public function value(): string;
}
