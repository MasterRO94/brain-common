<?php

declare(strict_types=1);

namespace Brain\Common\Normalisation;

use Brain\Common\Normalisation\Exception\PostalCodeInvalidException;
use Brain\Common\Normalisation\Validator\PostCodeValidator;

/**
 * {@inheritdoc}
 */
final class PostalCode implements PostalCodeInterface
{
    /** @var string */
    private $country;

    /** @var string */
    private $standardised;

    /** @var bool */
    private $valid;

    public function __construct(string $value, string $country)
    {
        $this->country = $country;

        $validator = new PostCodeValidator();

        if ($validator->hasCountryFormat($country) === false) {
            $this->valid = false;

            return;
        }

        $this->valid = $validator->isValid($value, $country);

        if ($this->valid !== true) {
            return;
        }

        $this->standardised = $validator->standardise($value);
    }

    /**
     * {@inheritdoc}
     */
    public function getCountryIso(): string
    {
        return $this->country;
    }

    /**
     * {@inheritdoc}
     */
    public function isValid(): bool
    {
        return $this->valid;
    }

    /**
     * Magic conversion to string.
     */
    public function __toString(): string
    {
        return $this->getStandardised();
    }

    /**
     * {@inheritdoc}
     *
     * @throws PostalCodeInvalidException When the postcode is not valid.
     */
    public function getStandardised(): string
    {
        if ($this->standardised === null) {
            throw PostalCodeInvalidException::create();
        }

        return $this->standardised;
    }
}
