<?php

declare(strict_types=1);

namespace Brain\Common\Database\Pagination\Adapter;

use ArrayIterator;
use Pagerfanta\Adapter\AdapterInterface;
use Traversable;

/**
 * {@inheritdoc}
 */
final class PassThroughPaginatorAdapter implements AdapterInterface
{
    /** @var mixed[] */
    private $data;

    /** @var int */
    private $total;

    /**
     * @param mixed[] $data
     */
    public function __construct(array $data, int $total)
    {
        $this->data = $data;
        $this->total = $total;
    }

    /**
     * {@inheritdoc}
     */
    public function getNbResults(): int
    {
        return $this->total;
    }

    /**
     * {@inheritdoc}
     */
    public function getSlice($offset, $length): Traversable
    {
        return new ArrayIterator($this->data);
    }
}
