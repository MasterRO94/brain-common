<?php

declare(strict_types=1);

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
