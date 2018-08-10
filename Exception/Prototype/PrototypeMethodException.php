<?php

declare(strict_types=1);

namespace Brain\Common\Exception\Prototype;

use Brain\Common\Exception\AbstractBrainRuntimeException;

/**
 * {@inheritdoc}
 */
final class PrototypeMethodException extends AbstractBrainRuntimeException
{
    /**
     * @param mixed $object
     *
     * @return PrototypeMethodException
     */
    public static function createForIdentityMissing($object): self
    {
        return new self(implode(' ', [
            'The method "getId()" cannot be called because the identity is not available right now.',
            'If you wish to test for the identity then make use of the "hasId()" method or capture this exception.',
            sprintf('This was executed on the class "%s".', get_class($object)),
        ]));
    }

    /**
     * @param mixed $object
     *
     * @return PrototypeMethodException
     */
    public static function createForCreatedDateMissing($object): self
    {
        return new self(implode(' ', [
            'The method "getCreated()" cannot be called because the created date is not available right now.',
            'If you wish to test for the created date then make use of the "hasCreated()" method or capture this exception.',
            sprintf('This was executed on the class "%s".', get_class($object)),
        ]));
    }

    /**
     * @param mixed $object
     *
     * @return PrototypeMethodException
     */
    public static function createForUpdatedDateMissing($object): self
    {
        return new self(implode(' ', [
            'The method "getUpdated()" cannot be called because the updated date is not available right now.',
            'If you wish to test for the updated date then make use of the "hasUpdated()" method or capture this exception.',
            sprintf('This was executed on the class "%s".', get_class($object)),
        ]));
    }

    /**
     * @param mixed $object
     *
     * @return PrototypeMethodException
     */
    public static function createForDeletedDateMissing($object): self
    {
        return new self(implode(' ', [
            'The method "getDeleted()" cannot be called because the deleted date is not available right now.',
            'If you wish to test for the deleted date then make use of the "hasDeleted()" method or capture this exception.',
            sprintf('This was executed on the class "%s".', get_class($object)),
        ]));
    }
}
