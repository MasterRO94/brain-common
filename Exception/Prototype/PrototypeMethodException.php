<?php

namespace Brain\Common\Exception\Prototype;

use Brain\Common\Exception\AbstractBrainRuntimeException;

/**
 * {@inheritdoc}
 */
final class PrototypeMethodException extends AbstractBrainRuntimeException
{
    /**
     * @param object $object
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
     * @param object $object
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
}
