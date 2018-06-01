<?php

namespace Brain\Common\Translation;

/**
 * A translator.
 */
interface TranslatorInterface
{
    /**
     * Return the current default locale.
     *
     * @return string
     */
    public function getLocale(): string;

    /**
     * Translate the given message.
     *
     * @param string $domain #TranslationDomain
     * @param string $id #TranslationKey
     * @param string[] $parameters
     * @param string|null $locale
     *
     * @return string
     */
    public function translate(string $domain, string $id, array $parameters = [], string $locale = null): string;
}
