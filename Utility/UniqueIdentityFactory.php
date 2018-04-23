<?php

namespace Brain\Common\Utility;

use Ramsey\Uuid\UuidFactory;

/**
 * A factory for creating unique identities.
 */
final class UniqueIdentityFactory implements UniqueIdentityFactoryInterface
{
    private $uuid;

    /**
     * Constructor.
     *
     * @param UuidFactory $uuid
     */
    public function __construct(UuidFactory $uuid)
    {
        $this->uuid = $uuid;
    }

    /**
     * {@inheritdoc}
     */
    public function uuid(): string
    {
        return $this->uuid->uuid4();
    }
}
