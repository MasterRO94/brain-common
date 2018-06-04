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
    private $locale;

    /**
     * Constructor.
     *
     * @param SymfonyTranslatorInterface $translator
     * @param string|null $locale
     */
    public function __construct(SymfonyTranslatorInterface $translator, string $locale)
    {
        $this->translator = $translator;
        $this->locale = $locale;
    }

    /**
     * {@inheritdoc}
     */
    public function getLocale(): string
    {
        return $this->locale;
    }

    /**
     * {@inheritdoc}
     *
     * @param string $domain #TranslationDomain
     * @param string $id #TranslationKey
     */
    public function translate(string $domain, string $id, array $parameters = [], string $locale = null): string
    {
        return $this->translator->trans($id, $parameters, $domain, $locale ?? $this->locale);
    }
}
