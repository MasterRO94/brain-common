<?php

declare(strict_types=1);

namespace Brain\Common\Form\Type\Entity;

/**
 * A column lookup definition for the form event subscriber.
 */
final class EntityLookupDefinition
{
    public const UUID_REGEX = '/^[a-z0-9]{8}\-[a-z0-9]{4}\-[a-z0-9]{4}\-[a-z0-9]{4}\-[a-z0-9]{12}$/';
    private const TYPE_STRING = 'string';
    private const TYPE_INTEGER = 'integer';

    /** @var string */
    private $column;

    /** @var string */
    private $type;

    /** @var mixed|null */
    private $default;

    /** @var string|null */
    private $regex;

    /**
     * Create an instance.
     *
     * @param mixed $default
     *
     * @return EntityLookupDefinition
     */
    public static function create(string $column, $default = null): self
    {
        return new self($column, $default);
    }

    /**
     * @param mixed $default
     */
    private function __construct(string $column, $default = null)
    {
        $this->column = $column;
        $this->default = $default;

        $this->setTypeString();
    }

    /**
     * Return the database column name.
     */
    public function getColumn(): string
    {
        return $this->column;
    }

    /**
     * Return the value type.
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Check if the type is string.
     */
    public function isTypeString(): bool
    {
        return $this->type === self::TYPE_STRING;
    }

    /**
     * Set the type to string.
     *
     * @return EntityLookupDefinition
     */
    public function setTypeString(): self
    {
        $this->type = self::TYPE_STRING;

        return $this;
    }

    /**
     * Check if the type is integer.
     */
    public function isTypeInteger(): bool
    {
        return $this->type === self::TYPE_INTEGER;
    }

    /**
     * Set the type to integer.
     *
     * @return EntityLookupDefinition
     */
    public function setTypeInteger(): self
    {
        $this->type = self::TYPE_INTEGER;

        return $this;
    }

    /**
     * Return the default.
     *
     * @return mixed|null
     */
    public function getDefault()
    {
        return $this->default;
    }

    /**
     * Return the regex.
     */
    public function getRegex(): ?string
    {
        return $this->regex;
    }

    /**
     * Set the regex to match.
     *
     * @return EntityLookupDefinition
     */
    public function setRegex(string $regex): self
    {
        $this->regex = $regex;

        return $this;
    }

    /**
     * Set the regex to match UUID.
     *
     * Note when using this it will assert the UUID format. This will cause you issues in development
     * where you try to validate a string. Instead always prefer to give an object with the "id" key
     * so the subscriber can pick it instead of guess.
     *
     * @return EntityLookupDefinition
     */
    public function setRegexIdentity(): self
    {
        $this->regex = self::UUID_REGEX;

        return $this;
    }
}
