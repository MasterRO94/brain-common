<?php

namespace Brain\Common\Translation;

/**
 * A translator.
 */
interface TranslatorInterface
{
    /**
     * Translate the given message.
     *
     * @param string $domain #TranslationDomain
     * @param string $id #TranslationKey
     * @param array $parameters
     * @param string|null $locale
     *
     * @return string
     */
    public function translate(string $domain, string $id, array $parameters = [], string $locale = null): string;
}
