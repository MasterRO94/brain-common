<?php

declare(strict_types=1);

namespace Brain\Common\Translation;

/**
 * A translator.
 */
interface TranslatorInterface
{
    /**
     * Return the current default locale.
     */
    public function getLocale(): string;

    /**
     * Translate the given message.
     *
     * @param string $domain #TranslationDomain
     * @param string $id #TranslationKey
     * @param string[] $parameters
     */
    public function translate(string $domain, string $id, array $parameters = [], ?string $locale = null): string;
}
