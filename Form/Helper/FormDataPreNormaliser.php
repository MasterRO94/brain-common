<?php

declare(strict_types=1);

namespace Brain\Common\Form\Helper;

use Brain\Common\Form\Type\Entity\EntityLookupDefinition;

final class FormDataPreNormaliser
{
    public const UUID_REGEX = '/^[a-z0-9]{8}\-[a-z0-9]{4}\-[a-z0-9]{4}\-[a-z0-9]{4}\-[a-z0-9]{12}$/';

    /**
     * Check if the form data has the key.
     *
     * @param mixed $value
     */
    public static function hasFormDataKey($value, string $key): bool
    {
        if (is_array($value) === false) {
            return false;
        }

        if (isset($value[$key]) === false) {
            return false;
        }

        return true;
    }

    /**
     * Normalise the form data for a standard id/alias form.
     *
     * @deprecated
     *
     * @param mixed[]|string|null $data
     * @param mixed[] $options
     *
     * @return mixed[]
     */
    public static function normalise($data, array $options = []): array
    {
        $options = array_merge([
            'assumeUuidIfString' => false,
        ], $options);

        $normalised = [
            'id' => null,
            'alias' => null,
        ];

        if ($data === null) {
            return $normalised;
        }

        // If the data is an array then we can assume that its kind of correct.
        // Merge it with the normalised template and return.
        if (is_array($data)) {
            return array_merge($normalised, $data);
        }

        // Working out if the data is a string then we need to know if its the id or alias.
        if ($options['assumeUuidIfString']
            || preg_match(self::UUID_REGEX, $data)
        ) {
            $normalised['id'] = $data;
        } else {
            $normalised['alias'] = $data;
        }

        return $normalised;
    }

    /**
     * Normalise form data to meet the definitions specified.
     *
     * @param mixed $data
     * @param EntityLookupDefinition[] $definitions
     *
     * @return mixed[]
     */
    public static function normaliseForMappedColumns($data, array $definitions): array
    {
        $normalised = self::prepareArrayForDefinitions($definitions);

        if ($data === null) {
            return $normalised;
        }

        // If the data is an array then we can assume that its kind of correct.
        // Merge it with the normalised template and return.
        if (is_array($data)) {
            return array_merge($normalised, $data);
        }

        // If the data is not a string then we cannot run regex against it.
        // Return the normalised array and assume nothing matched.
        if (!is_string($data)) {
            return $normalised;
        }

        // Case where a single definition is defined then logically we can assume the
        // string value should just be normalised to that property.
        if (count($definitions) === 1) {
            foreach ($definitions as $property => $definition) {
                $normalised[$property] = self::cast($data, $definition);

                return $normalised;
            }
        }

        // For each definition check if there is regex, if so match it.
        // On the first match break and return.
        foreach ($definitions as $property => $definition) {
            $regex = $definition->getRegex();

            // No regex means we are greedy and accept anything.
            if ($regex === null) {
                $normalised[$property] = self::cast($data, $definition);
                break;
            }

            // Otherwise match regex.
            if (preg_match($regex, $data)) {
                $normalised[$property] = $data;
                break;
            }
        }

        return $normalised;
    }

    /**
     * Prepare a normalised array using the definitions.
     *
     * @param EntityLookupDefinition[] $definitions
     *
     * @return mixed[]
     */
    public static function prepareArrayForDefinitions(array $definitions): array
    {
        $data = [];

        // Validate the array is an array of column lookup definitions.
        // This will cause PHP errors and is expected.
        array_walk($definitions, static function (EntityLookupDefinition $definition): void {
            return;
        });

        // Prepare the normalised array with all the mapped columns set as null.
        foreach ($definitions as $property => $definition) {
            $data[$property] = $definition->getDefault();
        }

        return $data;
    }

    /**
     * Handle casting of the data.
     *
     * @param mixed $data
     *
     * @return mixed
     */
    private static function cast($data, EntityLookupDefinition $definition)
    {
        if ($definition->isTypeString()) {
            return (string) $data;
        }

        if ($definition->isTypeInteger()) {
            if (is_numeric($data)) {
                return (int) $data;
            }

            return null;
        }

        return null;
    }
}
