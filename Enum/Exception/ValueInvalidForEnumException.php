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

    /** @var string */
    private $value;

    /** @var string[] */
    private $values;

    /**
     * @param string[] $values
     */
    public function __construct(string $enum, string $value, array $values)
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
     * @param string[] $values
     *
     * @return ValueInvalidForEnumException
     */
    public static function create(string $enum, string $value, array $values): self
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
     */
    public function getInvalidValue(): string
    {
        return $this->value;
    }

    /**
     * Return the valid values.
     *
     * @return string[]
     */
    public function getValues(): array
    {
        return $this->values;
    }
}
