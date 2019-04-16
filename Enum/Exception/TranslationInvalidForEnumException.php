<?php

declare(strict_types=1);

namespace Brain\Common\Enum\Exception;

use Exception;

/**
 * For enum validation.
 */
final class TranslationInvalidForEnumException extends Exception
{
    /** @var string */
    private $enum;

    /** @var string */
    private $translation;

    /** @var string[] */
    private $translations;

    /**
     * @param string[] $translations
     */
    public function __construct(string $enum, string $translation, array $translations)
    {
        $message = implode(' ', [
            'The translation "%s" is not valid for enum %s.',
            'Please make sure its one of the following: %s',
        ]);

        $message = sprintf($message, $translation, $enum, implode(', ', $translations));

        parent::__construct($message);

        $this->enum = $enum;
        $this->translation = $translation;
        $this->translations = $translations;
    }

    /**
     * @param string[] $translations
     *
     * @return TranslationInvalidForEnumException
     */
    public static function create(string $enum, string $translation, array $translations): self
    {
        return new self($enum, $translation, $translations);
    }

    /**
     * Return the enum class.
     */
    public function getEnumClass(): string
    {
        return $this->enum;
    }

    /**
     * Return the given invalid translation.
     */
    public function getInvalidTranslation(): string
    {
        return $this->translation;
    }

    /**
     * Return the valid translations.
     *
     * @return string[]
     */
    public function getTranslations(): array
    {
        return $this->translations;
    }
}
