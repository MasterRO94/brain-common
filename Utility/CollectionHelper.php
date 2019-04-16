<?php

declare(strict_types=1);

namespace Brain\Common\Utility;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use Traversable;

/**
 * A collection helper.
 */
final class CollectionHelper
{
    /**
     * Convert any collection-like in to an array collection.
     *
     * @param Collection|mixed[]|Traversable $iterable
     *
     * @return Collection|mixed[]
     */
    public static function convert($iterable): Collection
    {
        if ($iterable instanceof Collection) {
            return $iterable;
        }

        if (is_array($iterable)) {
            return new ArrayCollection($iterable);
        }

        return new ArrayCollection(iterator_to_array($iterable));
    }
}
