<?php

declare(strict_types=1);

namespace Brain\Common\Enum;

/**
 * An enum of string or integers.
 */
interface EnumInterface
{
    /**
     * Return all values within the enum.
     *
     * @return string[]|int[]
     */
    public static function all(bool $sort = false): array;

    /**
     * Check if the enum has the value.
     *
     * @param string|int $value
     */
    public static function has($value): bool;

    /**
     * Return the enum value.
     *
     * @return string|int
     */
    public function value();

    /**
     * Check this matches the given enum.
     *
     * This is essentially a wrapper around the {@link isValue()} method.
     */
    public function is(EnumInterface $value): bool;

    /**
     * Check the value matches the given enum value
     *
     * @param string|int $value
     */
    public function isValue($value): bool;
}
