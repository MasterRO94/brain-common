<?php

declare(strict_types=1);

namespace Brain\Common\Enum\Exception;

use Exception;

/**
 * For enum validation.
 */
final class ValueInvalidForEnumException extends Exception
{
    /** @var string */
    private $enum;

    /** @var string|int */
    private $value;

    /** @var string[]|int[] */
    private $values;

    /**
     * @param string|int $value
     * @param string[]|int[] $values
     */
    public function __construct(string $enum, $value, array $values)
    {
        $message = implode(' ', [
            'The value "%s" is not valid for enum %s.',
            'Please make sure its one of the following: %s',
        ]);

        $message = sprintf($message, $value, $enum, implode(', ', $values));

        parent::__construct($message);

        $this->enum = $enum;
        $this->value = $value;
        $this->values = $values;
    }

    /**
     * @param string|int $value
     * @param string[]|int[] $values
     *
     * @return ValueInvalidForEnumException
     */
    public static function create(string $enum, $value, array $values): self
    {
        return new self($enum, $value, $values);
    }

    /**
     * Return the enum class.
     */
    public function getEnumClass(): string
    {
        return $this->enum;
    }

    /**
     * Return the given invalid value.
     *
     * @return string|int
     */
    public function getInvalidValue()
    {
        return $this->value;
    }

    /**
     * Return the valid values.
     *
     * @return string[]|int[]
     */
    public function getValues(): array
    {
        return $this->values;
    }
}
