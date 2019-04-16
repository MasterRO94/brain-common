<?php

declare(strict_types=1);

namespace Brain\Common\Tests\Fixture\Database;

use Brain\Common\Database\EntityInterface;
use Brain\Common\Prototype\Column\IdentityAwareInterface;
use Brain\Common\Prototype\Column\IdentityAwareTrait;

/**
 * Entity representation with id awareness only.
 *
 * @internal Test fixture only.
 */
final class BasicEntityIdentityAwareTestFixture implements
    EntityInterface,
    IdentityAwareInterface
{
    use IdentityAwareTrait;

    /** @var int|null */
    protected $id;

    /**
     * Fixture method for setting id.
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }
}
