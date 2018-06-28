<?php

namespace Brain\Common\Normalisation;

interface PostalCodeInterface
{
    /**
     * Return the country iso.
     */
    public function getCountryIso(): string;

    /**
     * Return the standardised string.
     */
    public function getStandardised(): string;

    /**
     * Check if the postal code is valid.
     */
    public function isValid(): bool;
}
