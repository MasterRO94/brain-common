<?php

declare(strict_types=1);

namespace Brain\Common\Tests\Fixture\Enum;

use Brain\Common\Enum\AbstractEnum;

/**
 * An example enum.
 *
 * @internal
 */
final class ExampleTestFixtureEnum extends AbstractEnum
{
    public const EXAMPLE_VALID = 'valid';
    public const EXAMPLE_NORMAL = 'normal';

    /**
     * {@inheritdoc}
     */
    protected static function getTranslationPrefix(): string
    {
        return 'prefix';
    }

    /**
     * {@inheritdoc}
     */
    protected static function getValues(): array
    {
        return [
            self::EXAMPLE_VALID,
            self::EXAMPLE_NORMAL,
        ];
    }
}
