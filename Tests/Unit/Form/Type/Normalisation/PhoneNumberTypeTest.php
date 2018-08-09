<?php

declare(strict_types=1);

namespace Brain\Common\Tests\Unit\Form\Type\Normalisation;

use Brain\Common\Form\Type\Normalisation\PhoneNumberType;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\Test\TypeTestCase;

/**
 * {@inheritdoc}
 */
final class PhoneNumberTypeTest extends TypeTestCase
{
    /**
     * @test
     *
     * @group unit
     * @group form
     * @group normalisation
     *
     * @covers \Brain\Common\Form\Type\Normalisation\PhoneNumberType
     */
    public function withNullValueResolveNull(): void
    {
        $builder = $this->factory->createBuilder();
        $builder->add('number', PhoneNumberType::class);

        $form = $builder->getForm();

        $data = [
            'number' => null,
        ];

        $form->submit($data);

        $expected = [
            'number' => null,
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
     * @covers \Brain\Common\Form\Type\Normalisation\PhoneNumberType
     */
    public function withValueAndCountryIsoNullReturnNull(): void
    {
        $builder = $this->factory->createBuilder();
        $builder->add('number', PhoneNumberType::class, [
            'country_iso' => null,
        ]);

        $form = $builder->getForm();

        $data = [
            'number' => '+(932) 234222d3 2324',
        ];

        $form->submit($data);

        $expected = [
            'number' => null,
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
     * @covers \Brain\Common\Form\Type\Normalisation\PhoneNumberType
     */
    public function withInvalidPhoneNumberResolveNull(): void
    {
        $builder = $this->factory->createBuilder();
        $builder->add('number', PhoneNumberType::class, [
            'country_iso' => 'GB',
        ]);

        $form = $builder->getForm();

        $data = [
            'number' => '+(932) 234222d3 2324',
        ];

        $form->submit($data);

        $expected = [
            'number' => null,
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
     * @covers \Brain\Common\Form\Type\Normalisation\PhoneNumberType
     */
    public function withValidPhoneNumberStandardise(): void
    {
        $builder = $this->factory->createBuilder();
        $builder->add('number', PhoneNumberType::class, [
            'country_iso' => 'GB',
        ]);

        $form = $builder->getForm();

        $data = [
            'number' => '07706260852',
        ];

        $form->submit($data);

        $expected = [
            'number' => '+447706260852',
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
     * @covers \Brain\Common\Form\Type\Normalisation\PhoneNumberType
     */
    public function withValidPhoneNumberPriorityResolver(): void
    {
        $builder = $this->factory->createBuilder();
        $builder->add('number', PhoneNumberType::class, [
            'country_iso' => 'NL',
            'country_iso_resolver' => function () {
                return 'GB';
            },
        ]);

        $form = $builder->getForm();

        $data = [
            'number' => '07706260852',
        ];

        $form->submit($data);

        $expected = [
            'number' => '+447706260852',
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
     * @covers \Brain\Common\Form\Type\Normalisation\PhoneNumberType
     */
    public function canCountryIsoResolveFromOtherField(): void
    {
        $builder = $this->factory->createBuilder();
        $builder->add('iso', TextType::class);
        $builder->add('number', PhoneNumberType::class, [
            'country_iso_resolver' => function (FormInterface $form) {
                return $form->get('iso')->getData();
            },
        ]);

        $form = $builder->getForm();

        $data = [
            'iso' => 'NL',
            'number' => '020 555 1111',
        ];

        $form->submit($data);

        $expected = [
            'iso' => 'NL',
            'number' => '+31205551111',
        ];

        self::assertEquals($expected, $form->getData());
    }
}
