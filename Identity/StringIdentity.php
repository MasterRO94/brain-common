<?php

declare(strict_types=1);

namespace Brain\Common\Identity;

use Brain\Common\Identity\Exception\StringIdentityInvalidException;
use Brain\Common\Regex\RegexMatch;
use Brain\Common\Representation\StringMagicRepresentationTrait;

/**
 * A string identity.
 */
final class StringIdentity implements
    StringIdentityInterface
{
    public const REGEX_UUID = '/^[a-z0-9]{8}\-[a-z0-9]{4}\-[a-z0-9]{4}\-[a-z0-9]{4}\-[a-z0-9]{12}$/';
    use StringMagicRepresentationTrait;

    /** @var string */
    private $id;

    /**
     * Create a default string identity (uuid).
     *
     * @return StringIdentity
     *
     * @throws StringIdentityInvalidException
     */
    public static function create(string $uuid): self
    {
        if (RegexMatch::match(self::REGEX_UUID, $uuid) === false) {
            throw StringIdentityInvalidException::uuid($uuid);
        }

        $uuid = strtolower($uuid);

        return new self($uuid);
    }

    /**
     * Constructor is protected to enforce a static factory method.
     * The factory method should perform validation as required.
     */
    private function __construct(string $id)
    {
        $this->id = $id;
    }

    /**
     * {@inheritdoc}
     */
    public function isEqual(StringIdentityInterface $comparison): bool
    {
        return $this->id === $comparison->toString();
    }

    /**
     * {@inheritdoc}
     */
    public function toString(): string
    {
        return $this->id;
    }
}
