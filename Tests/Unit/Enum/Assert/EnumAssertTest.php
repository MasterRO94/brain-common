<?php

declare(strict_types=1);

namespace Brain\Common\Tests\Unit\Enum\Assert;

use Brain\Common\Enum\Assert\EnumAssert;
use Brain\Common\Enum\Exception\ValueInvalidForEnumException;
use Brain\Common\Tests\Fixture\Enum\ExampleTestFixtureEnum;

use PHPUnit\Framework\TestCase;

/**
 * @group unit
 * @group enum
 *
 * @covers \Brain\Common\Enum\Assert\EnumAssert
 */
final class EnumAssertTest extends TestCase
{
    /**
     * @test
     */
    public function canDetectInvalidValue(): void
    {
        self::expectException(ValueInvalidForEnumException::class);
        self::expectExceptionMessage(implode(' ', [
            sprintf('The value "invalid" is not valid for enum %s.', ExampleTestFixtureEnum::class),
            'Please make sure its one of the following: valid, normal',
        ]));

        EnumAssert::validate(ExampleTestFixtureEnum::class, 'invalid');
    }

    /**
     * @test
     */
    public function withValidValueDoNothing(): void
    {
        EnumAssert::validate(ExampleTestFixtureEnum::class, 'valid');

        /** @var mixed $mixed */
        $mixed = true;
        self::assertTrue($mixed);
    }
}
