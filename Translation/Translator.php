<?php

declare(strict_types=1);

namespace Brain\Common\Translation;

use Symfony\Contracts\Translation\TranslatorInterface as SymfonyTranslatorInterface;

/**
 * A translator wrapper that tweaks the Symfony translation api slightly.
 */
final class Translator implements TranslatorInterface
{
    /** @var SymfonyTranslatorInterface */
    private $translator;

    /** @var string */
    private $locale;

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
    public function translate(string $domain, string $id, array $parameters = [], ?string $locale = null): string
    {
        return $this->translator->trans($id, $parameters, $domain, $locale ?? $this->locale);
    }
}
