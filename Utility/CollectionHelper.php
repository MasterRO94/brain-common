<?php

declare(strict_types=1);

namespace Brain\Common\Utility;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use LogicException;
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
     * @throws LogicException When the $iterable cannot be handled.
     *
     * @return mixed[]|ArrayCollection
     */
    public static function convert($iterable): Collection
    {
        if ($iterable instanceof Collection) {
            return $iterable;
        }

        if ($iterable instanceof Traversable) {
            return new ArrayCollection(iterator_to_array($iterable));
        }

        if (is_array($iterable)) {
            return new ArrayCollection($iterable);
        }

        throw new LogicException(implode(' ', [
            'The iterable instance cannot be converted to a Collection.',
            'Please check the variable given and make sure it is valid.',
        ]));
    }
}
