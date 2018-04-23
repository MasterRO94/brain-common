<?php

declare(strict_types=1);

namespace Brain\Common\Translation;

use Symfony\Component\Translation\TranslatorInterface as SymfonyTranslatorInterface;

/**
 * A translator wrapper that tweaks the Symfony translation api slightly.
 */
final class Translator implements TranslatorInterface
{
    private $translator;

    /**
     * Constructor.
     *
     * @param SymfonyTranslatorInterface $translator
     */
    public function __construct(SymfonyTranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

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
    public function translate(string $domain, string $id, array $parameters = [], string $locale = null): string
    {
        return $this->translator->trans($id, $parameters, $domain, $locale);
    }
}
