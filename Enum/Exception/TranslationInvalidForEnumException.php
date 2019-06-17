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

    /** @var string|int */
    private $translation;

    /** @var string[]|int[] */
    private $translations;

    /**
     * @param string|int $translation
     * @param string[]|int[] $translations
     *
     * @return TranslationInvalidForEnumException
     */
    public static function create(string $enum, $translation, array $translations): self
    {
        return new self($enum, $translation, $translations);
    }

    /**
     * @param string|int $translation
     * @param string[]|int[] $translations
     */
    public function __construct(string $enum, $translation, array $translations)
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
     * Return the enum class.
     */
    public function getEnumClass(): string
    {
        return $this->enum;
    }

    /**
     * Return the given invalid translation.
     *
     * @return string|int
     */
    public function getInvalidTranslation()
    {
        return $this->translation;
    }

    /**
     * Return the valid translations.
     *
     * @return string[]|int[]
     */
    public function getTranslations(): array
    {
        return $this->translations;
    }
}
