<?php

declare(strict_types=1);

namespace Brain\Common\Identity\Exception;

use Exception;

final class StringIdentityInvalidException extends Exception
{
    /** @var string */
    private $id;

    /**
     * @return StringIdentityInvalidException
     */
    public static function uuid(string $id): self
    {
        return new self($id, 'UUID');
    }

    public function __construct(string $id, string $type)
    {
        $message = implode(' ', [
            sprintf('The given identity "%s" is invalid.', $id),
            sprintf('Please provide a valid %s formatted string.', $type),
        ]);

        parent::__construct($message);

        $this->id = $id;
    }

    /**
     * Return the invalid identity.
     */
    public function getInvalidId(): string
    {
        return $this->id;
    }
}
