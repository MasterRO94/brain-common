<?php

declare(strict_types=1);

namespace Brain\Common\Spacial;

use Brain\Common\Representation\Type\IntegerRepresentationInterface;

/**
 * A representation of area.
 */
interface AreaInterface extends
    IntegerRepresentationInterface
{
    /**
     * Check this area is equal to another.
     */
    public function isEqual(AreaInterface $area): bool;

    /**
     * Check this area is less than the given area but not equal.
     */
    public function isLessThan(AreaInterface $area): bool;

    /**
     * Check this area is less than or equal to the given area.
     */
    public function isLessThanOrEqual(AreaInterface $area): bool;

    /**
     * Check this area is greater than the given area but not equal.
     */
    public function isGreaterThan(AreaInterface $area): bool;

    /**
     * Check this area is greater than or equal to the given area.
     */
    public function isGreaterThanOrEqual(AreaInterface $area): bool;

    /**
     * Check this area is between the given areas.
     *
     * This method is inclusive, meaning exact matches on either ends area true too.
     */
    public function isWithin(AreaInterface $lower, AreaInterface $upper): bool;
}
