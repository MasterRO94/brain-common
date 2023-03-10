<?php

declare(strict_types=1);

namespace Brain\Common\Normalisation;

use Brain\Common\Normalisation\Exception\PhoneNumberInvalidException;

use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumber as ExternalPhoneNumber;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberUtil;
use RuntimeException;

/**
 * {@inheritdoc}
 */
final class PhoneNumber implements PhoneNumberInterface
{
    /** @var ExternalPhoneNumber|null */
    private $parsed;

    /** @var bool */
    private $valid;

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
        $code = $this->getExtensionInstance()->getCountryCode();

        if ($code === null) {
            throw new RuntimeException('Country code could not be determined.');
        }

        return $code;
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
        $number = $this->getExtensionInstance()->getNationalNumber();

        if ($number === null) {
            throw new RuntimeException('National number could not be determined.');
        }

        return $number;
    }

    /**
     * {@inheritdoc}
     */
    public function getStandardised(): string
    {
        $instance = PhoneNumberUtil::getInstance();

        $format = PhoneNumberFormat::E164;
        $formatted = $instance->format($this->getExtensionInstance(), $format);

        return $formatted;
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
}
