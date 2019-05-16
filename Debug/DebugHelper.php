<?php

declare(strict_types=1);

namespace Brain\Common\Debug;

use Brain\Common\Prototype\Column\IdentityAwareInterface;

use Doctrine\Common\Persistence\Proxy;

/**
 * A helper for serialising and representing entities in debug.
 */
final class DebugHelper
{
    /**
     * Return the entity in a debug representation.
     *
     * @param mixed $entity
     * @param mixed[] $data
     *
     * @example ClassName(id=123, k=v, ...)
     */
    public static function represent($entity, array $data, bool $short = false): string
    {
        $class = self::getClassName($entity, $short);

        $parameters = implode(', ', array_filter([
            self::getAwareString($entity) ?: null,
            self::getParameterString($data) ?: null,
        ]));

        if ($parameters === '') {
            $parameters = 'none';
        }

        $representation = sprintf('%s{%s}', $class, $parameters);

        return $representation;
    }

    /**
     * @param mixed $entity
     *
     * Return the correct class name string.
     */
    private static function getClassName($entity, bool $short): string
    {
        /** @var string $class */
        $class = get_class($entity);

        if ($entity instanceof Proxy) {
            /** @var string $class */
            $class = get_parent_class($entity);
        }

        if ($short === true) {
            $parts = explode('\\', $class);

            /** @var string $class */
            $class = array_pop($parts);
        }

        return $class;
    }

    /**
     * @param mixed $entity
     *
     * Return any awareness data.
     */
    private static function getAwareString($entity): string
    {
        $data = [];

        if ($entity instanceof IdentityAwareInterface) {
            $data['id'] = $entity->hasId()
                ? $entity->getId()
                : null;
        }

        return self::getParameterString($data);
    }

    /**
     * Return the data as a string.
     *
     * @param mixed[] $data
     */
    private static function getParameterString(array $data): string
    {
        $processed = [];

        foreach ($data as $key => $value) {
            switch (true) {
                case ($value instanceof DebugInterface):
                    $processed[] = sprintf('%s=%s', $key, $value->toString(true));

                    break;
                case is_string($value):
                    $processed[] = sprintf('%s="%s"', $key, $value);

                    break;
                case is_int($value):
                    $processed[] = sprintf('%s=%s', $key, $value);

                    break;
                case is_bool($value):
                    $value = ($value === true)
                        ? 'true'
                        : 'false';

                    $processed[] = sprintf('%s=%s', $key, $value);

                    break;
                case $value === null:
                    $processed[] = sprintf('%s=null', $key);
            }
        }

        $representation = implode(', ', $processed);

        return $representation;
    }
}
