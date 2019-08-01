<?php

declare(strict_types=1);

namespace Brain\Common\Tests\Unit\Date\Enum;

use Brain\Common\Date\Enum\WeekdayEnum;
use Brain\Common\Enum\Exception\ValueInvalidForEnumException;
use Brain\Common\Exception\Developer\DeveloperContractRuntimeException;

use DateTime;
use DateTimeInterface;
use Exception;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * @group common
 * @group unit
 * @group date
 *
 * @covers \Brain\Common\Date\Enum\WeekdayEnum
 */
final class WeekdayEnumTest extends TestCase
{
    /**
     * Data provider.
     *
     * @return mixed[]
     *
     * @throws Exception
     */
    public function provideCanCreateFromDateTimeInterface(): array
    {
        return [
            [WeekdayEnum::DAY_TUESDAY, new DateTime('2019-01-01')],
            [WeekdayEnum::DAY_WEDNESDAY, new DateTime('2019-01-02')],
            [WeekdayEnum::DAY_THURSDAY, new DateTime('2019-01-03')],
            [WeekdayEnum::DAY_FRIDAY, new DateTime('2019-01-04')],
            [WeekdayEnum::DAY_SATURDAY, new DateTime('2019-01-05')],
            [WeekdayEnum::DAY_SUNDAY, new DateTime('2019-01-06')],
            [WeekdayEnum::DAY_MONDAY, new DateTime('2019-01-07')],
        ];
    }

    /**
     * @test
     * @dataProvider provideCanCreateFromDateTimeInterface
     */
    public function canCreateFromDateTimeInterface(int $expected, DateTimeInterface $date): void
    {
        $weekday = WeekdayEnum::createFromDateTimeInterface($date);

        self::assertEquals($expected, $weekday->value());
    }

    /**
     * @test
     */
    public function withInvalidDateTimeThrow(): void
    {
        /** @var DateTimeInterface|MockObject $date */
        $date = $this->createMock(DateTime::class);
        $date->expects(self::once())
            ->method('format')
            ->with('w')
            ->willReturn(15);

        try {
            WeekdayEnum::createFromDateTimeInterface($date);
        } catch (DeveloperContractRuntimeException $exception) {
            $previous = $exception->getPrevious();

            if (!($previous instanceof ValueInvalidForEnumException)) {
                self::fail(sprintf('Expected parent exception: %s', ValueInvalidForEnumException::class));
            }

            self::assertEquals(WeekdayEnum::class, $previous->getEnumClass());
            self::assertEquals(15, $previous->getInvalidValue());

            return;
        }

        self::fail(sprintf('Expecting exception: %s', DeveloperContractRuntimeException::class));
    }

    /**
     * Data provider.
     *
     * @return mixed[]
     */
    public function provideCanCreateFromValueEnsureExpectedValues(): array
    {
        return [
            [WeekdayEnum::DAY_SUNDAY, 0, 'sunday', 'weekday.sunday'],
            [WeekdayEnum::DAY_MONDAY, 1, 'monday', 'weekday.monday'],
            [WeekdayEnum::DAY_TUESDAY, 2, 'tuesday', 'weekday.tuesday'],
            [WeekdayEnum::DAY_WEDNESDAY, 3, 'wednesday', 'weekday.wednesday'],
            [WeekdayEnum::DAY_THURSDAY, 4, 'thursday', 'weekday.thursday'],
            [WeekdayEnum::DAY_FRIDAY, 5, 'friday', 'weekday.friday'],
            [WeekdayEnum::DAY_SATURDAY, 6, 'saturday', 'weekday.saturday'],
        ];
    }

    /**
     * @test
     * @dataProvider provideCanCreateFromValueEnsureExpectedValues
     *
     * @throws ValueInvalidForEnumException
     */
    public function canCreateFromValueEnsureExpectedValues(int $input, int $value, string $translation, string $prefixed): void
    {
        $weekday = new WeekdayEnum($input);

        self::assertEquals($value, $weekday->value());
        self::assertEquals($translation, $weekday->translation(false));
        self::assertEquals($prefixed, $weekday->translation());
    }
}
