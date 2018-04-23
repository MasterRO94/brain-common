<?php

namespace Brain\Common\Form\Type\Entity;

use Brain\Common\Form\Helper\FormDataPreNormaliser;

/**
 * A column lookup definition for the form event subscriber.
 */
final class EntityLookupDefinition
{
    private $column;
    private $default;

    /** @var string */
    private $regex;

    /**
     * Create an instance.
     *
     * @param string $column
     * @param mixed $default
     *
     * @return EntityLookupDefinition
     */
    public static function create(string $column, $default = null): self
    {
        return new self($column, $default);
    }

    /**
     * Constructor.
     *
     * @param string $column
     * @param mixed $default
     */
    private function __construct(string $column, $default = null)
    {
        $this->column = $column;
        $this->default = $default;
    }

    /**
     * Return the database column name.
     *
     * @return string
     */
    public function getColumn(): string
    {
        return $this->column;
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
     *
     * @return string|null
     */
    public function getRegex(): ?string
    {
        return $this->regex;
    }

    /**
     * Set the regex to match.
     *
     * @param string $regex
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
    public function setRegexUUID(): self
    {
        $this->regex = FormDataPreNormaliser::UUID_REGEX;

        return $this;
    }
}
