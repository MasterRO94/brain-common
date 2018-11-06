<?php

declare(strict_types=1);

namespace Brain\Common\Serializer;

final class SerializerFactoryHelper
{
    /**
     * A helper for serializing something properly.
     *
     * @param mixed $value
     * @param string[] $groups
     *
     * @return mixed
     */
    public static function serialize(SerializerFactory $factory, $value, array $groups = [])
    {
        $context = $factory->createContext($groups);
        $serialized = $context->getNavigator()->accept($value, null, $context);

        return $serialized;
    }
}
