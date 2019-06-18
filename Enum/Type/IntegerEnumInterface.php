<?php

declare(strict_types=1);

namespace Brain\Common\Enum\Type;

use Brain\Common\Enum\EnumInterface;

/**
 * A integer enum.
 *
 * Used to enforce strict typing on the overridden methods.
 * This can probably be fixed up a bit with PHP 7.4 covariance/contra-variance changes.
 */
interface IntegerEnumInterface extends
    EnumInterface
{
    /**
     * Return all values within the enum.
     *
     * @return int[]
     */
    public static function all(bool $sort = false): array;

    /**
     * Check if the enum has the value.
     *
     * @param int $value
     */
    public static function has($value): bool;

    /**
     * Return the enum value.
     */
    public function value(): int;

    /**
     * Check the value matches the given enum value
     *
     * @param int $value
     */
    public function isValue($value): bool;
}
