<?php

declare(strict_types=1);

namespace Brain\Common\Tests\Fixture\Enum\Type;

use Brain\Common\Enum\Type\Implementation\AbstractStringTranslationEnum;

/**
 * @internal For testing only.
 */
final class StringEnumTestFixture extends AbstractStringTranslationEnum
{
    public const VALUE_FOO = 'foo';
    public const VALUE_BAR = 'bar';

    /**
     * {@inheritdoc}
     */
    protected static function values(): array
    {
        return [
            self::VALUE_FOO,
            self::VALUE_BAR,
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected static function prefix(): string
    {
        return 'enum.string';
    }
}
