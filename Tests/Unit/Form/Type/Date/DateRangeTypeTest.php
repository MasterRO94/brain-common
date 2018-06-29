<?php

namespace Brain\Common\Tests\Unit\Form\Type\Date;

use Brain\Common\Date\Range\DateTimeRange;
use Brain\Common\Date\Range\OpenEndedDateTimeRange;
use Brain\Common\Form\Type\Date\DateRangeType;

use Symfony\Component\Form\Test\TypeTestCase;

use DateTime;

/**
 * {@inheritdoc}
 */
final class DateRangeTypeTest extends TypeTestCase
{
    /**
     * @test
     *
     * @group unit
     * @group form
     * @group normalisation
     *
     * @covers \Brain\Common\Form\Type\Date\DateRangeType
     */
    public function withNullValueResolveNull(): void
    {
        $builder = $this->factory->createBuilder();
        $builder->add('range', DateRangeType::class);

        $form = $builder->getForm();

        $data = [
            'range' => null,
        ];

        $form->submit($data);

        $expected = [
            'range' => null,
        ];

        self::assertEquals($expected, $form->getData());
    }

    /**
     * @test
     *
     * @group unit
     * @group form
     * @group normalisation
     *
     * @covers \Brain\Common\Form\Type\Date\DateRangeType
     */
    public function withDateStringValueResolveFrom(): void
    {
        $builder = $this->factory->createBuilder();
        $builder->add('range', DateRangeType::class);

        $form = $builder->getForm();

        $input = '2010-01-01 10:10:10';

        $data = [
            'range' => $input,
        ];

        $form->submit($data);

        $date = new DateTime($input);
        $range = OpenEndedDateTimeRange::createFrom($date);

        $expected = [
            'range' => $range,
        ];

        self::assertEquals($expected, $form->getData());
    }

    /**
     * @test
     *
     * @group unit
     * @group form
     * @group normalisation
     *
     * @covers \Brain\Common\Form\Type\Date\DateRangeType
     */
    public function withDateArrayValueResolveRange(): void
    {
        $builder = $this->factory->createBuilder();
        $builder->add('range', DateRangeType::class);

        $form = $builder->getForm();

        $from = '2010-01-01 10:10:10';
        $to = '2010-02-01 10:10:10';

        $data = [
            'range' => [
                'from' => $from,
                'to' => $to,
            ],
        ];

        $form->submit($data);

        $from = new DateTime($from);
        $to = new DateTime($to);

        $range = new DateTimeRange($from, $to);

        $expected = [
            'range' => $range,
        ];

        self::assertEquals($expected, $form->getData());
    }

    /**
     * @test
     *
     * @group unit
     * @group form
     * @group normalisation
     *
     * @covers \Brain\Common\Form\Type\Date\DateRangeType
     */
    public function withDateArrayFromOnlyValueResolveFrom(): void
    {
        $builder = $this->factory->createBuilder();
        $builder->add('range', DateRangeType::class);

        $form = $builder->getForm();

        $input = '2010-01-01 10:10:10';

        $data = [
            'range' => [
                'from' => $input,
            ],
        ];

        $form->submit($data);

        $date = new DateTime($input);
        $range = OpenEndedDateTimeRange::createFrom($date);

        $expected = [
            'range' => $range,
        ];

        self::assertEquals($expected, $form->getData());
    }

    /**
     * @test
     *
     * @group unit
     * @group form
     * @group normalisation
     *
     * @covers \Brain\Common\Form\Type\Date\DateRangeType
     */
    public function withDateArrayToOnlyValueResolveFrom(): void
    {
        $builder = $this->factory->createBuilder();
        $builder->add('range', DateRangeType::class);

        $form = $builder->getForm();

        $input = '2010-01-01 10:10:10';

        $data = [
            'range' => [
                'to' => $input,
            ],
        ];

        $form->submit($data);

        $date = new DateTime($input);
        $range = OpenEndedDateTimeRange::createTo($date);

        $expected = [
            'range' => $range,
        ];

        self::assertEquals($expected, $form->getData());
    }

    /**
     * @test
     *
     * @group unit
     * @group form
     * @group normalisation
     *
     * @covers \Brain\Common\Form\Type\Date\DateRangeType
     */
    public function withDateEmptyArrayResolveNull(): void
    {
        $builder = $this->factory->createBuilder();
        $builder->add('range', DateRangeType::class);

        $form = $builder->getForm();

        $data = [
            'range' => [],
        ];

        $form->submit($data);

        $expected = [
            'range' => null,
        ];

        self::assertEquals($expected, $form->getData());
    }
}
