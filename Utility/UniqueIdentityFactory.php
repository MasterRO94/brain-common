<?php

declare(strict_types=1);

namespace Brain\Common\Utility;

use Ramsey\Uuid\UuidFactory;

/**
 * A factory for creating unique identities.
 */
final class UniqueIdentityFactory implements UniqueIdentityFactoryInterface
{
    private $uuid;

    public function __construct(UuidFactory $uuid)
    {
        $this->uuid = $uuid;
    }

    /**
     * {@inheritdoc}
     */
    public function uuid(): string
    {
        return $this->uuid->uuid4()->toString();
    }
}
