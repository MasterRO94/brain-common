<?php

namespace Brain\Common\Normalisation;

use Brain\Common\Normalisation\Exception\PhoneNumberInvalidException;

use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumber as ExternalPhoneNumber;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberUtil;

/**
 * {@inheritdoc}
 */
final class PhoneNumber implements PhoneNumberInterface
{
    /** @var ExternalPhoneNumber */
    private $parsed;

    /** @var bool */
    private $valid;

    /**
     * @param string $value
     * @param string $country
     *
     * @throws PhoneNumberInvalidException When phone number is invalid.
     */
    public function __construct(string $value, string $country)
    {
        $instance = PhoneNumberUtil::getInstance();

        try {
            $this->parsed = $instance->parse($value, $country);
            $this->valid = $instance->isValidNumber($this->parsed);
        } catch (NumberParseException $exception) {
            $this->valid = false;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getCountryCode(): int
    {
        return $this->getExtensionInstance()->getCountryCode();
    }

    /**
     * Return the phone number instance that is used under the hood.
     */
    public function getExtensionInstance(): ExternalPhoneNumber
    {
        if ($this->parsed instanceof ExternalPhoneNumber) {
            return $this->parsed;
        }

        throw PhoneNumberInvalidException::create();
    }

    /**
     * {@inheritdoc}
     */
    public function getNationalNumber(): string
    {
        return $this->getExtensionInstance()->getNationalNumber();
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
        return $this->getStandardisedNumber();
    }

    /**
     * {@inheritdoc}
     */
    public function getStandardisedNumber(): string
    {
        $instance = PhoneNumberUtil::getInstance();

        $format = PhoneNumberFormat::E164;
        $formatted = $instance->format($this->getExtensionInstance(), $format);

        return $formatted;
    }
}
