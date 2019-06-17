<?php

declare(strict_types=1);

namespace Brain\Common\Tests\Fixture\Enum\Type;

use Brain\Common\Enum\Type\Implementation\AbstractIntegerTranslationEnum;

/**
 * @internal For testing only.
 */
final class IntegerEnumTestFixture extends AbstractIntegerTranslationEnum
{
    public const VALUE_ZERO = 0;
    public const VALUE_ONE = 1;

    /**
     * {@inheritdoc}
     */
    protected static function values(): array
    {
        return [
            self::VALUE_ONE,
            self::VALUE_ZERO,
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected static function prefix(): string
    {
        return 'enum.integer';
    }

    /**
     * {@inheritdoc}
     */
    protected static function translations(): array
    {
        return [
            self::VALUE_ZERO => 'zero',
            self::VALUE_ONE => 'one',
        ];
    }
}
