<?php

declare(strict_types=1);

namespace Brain\Common\Identity\Factory;

use Brain\Common\Exception\Developer\DeveloperContractRuntimeException;
use Brain\Common\Identity\Exception\StringIdentityInvalidException;
use Brain\Common\Identity\StringIdentity;
use Brain\Common\Identity\StringIdentityInterface;
use Brain\Common\Utility\UniqueIdentityFactoryInterface;

/**
 * A factory for creating string identities.
 */
final class StringIdentityFactory implements
    StringIdentityFactoryInterface
{
    /** @var UniqueIdentityFactoryInterface */
    private $factory;

    public function __construct(UniqueIdentityFactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    /**
     * {@inheritdoc}
     */
    public function create(): StringIdentityInterface
    {
        try {
            return StringIdentity::create($this->factory->uuid());
        } catch (StringIdentityInvalidException $exception) {
            throw DeveloperContractRuntimeException::create($exception);
        }
    }
}
