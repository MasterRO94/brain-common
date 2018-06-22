<?php

namespace Brain\Common\Normalisation;

interface PhoneNumberInterface
{
    /**
     * Return the country code.
     *
     * Note, this valid is just the two digit integer and will not include symbols.
     */
    public function getCountryCode(): int;

    /**
     * Return the actual number without country code.
     *
     * Note, this will be stripped of space.
     */
    public function getNationalNumber(): string;

    /**
     * Return the standardised string.
     */
    public function getStandardised(): string;

    /**
     * Check if the phone number is valid.
     */
    public function isValid(): bool;
}
