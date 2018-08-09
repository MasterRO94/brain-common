<?php

declare(strict_types=1);

namespace Brain\Common\Tests\Unit\Form\Type\Normalisation;

use Brain\Common\Form\Type\Normalisation\PostalCodeType;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\Test\TypeTestCase;

/**
 * {@inheritdoc}
 */
final class PostalCodeTypeTest extends TypeTestCase
{
    /**
     * @test
     *
     * @group unit
     * @group form
     * @group normalisation
     *
     * @covers \Brain\Common\Form\Type\Normalisation\PostalCodeType
     */
    public function withNullValueResolveNull(): void
    {
        $builder = $this->factory->createBuilder();
        $builder->add('postcode', PostalCodeType::class);

        $form = $builder->getForm();

        $data = [
            'postcode' => null,
        ];

        $form->submit($data);

        $expected = [
            'postcode' => null,
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
     * @covers \Brain\Common\Form\Type\Normalisation\PostalCodeType
     */
    public function withValueAndCountryIsoNullReturnNull(): void
    {
        $builder = $this->factory->createBuilder();
        $builder->add('postcode', PostalCodeType::class, [
            'country_iso' => null,
        ]);

        $form = $builder->getForm();

        $data = [
            'postcode' => 'INVALID',
        ];

        $form->submit($data);

        $expected = [
            'postcode' => null,
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
     * @covers \Brain\Common\Form\Type\Normalisation\PostalCodeType
     */
    public function withInvalidPostalCodeResolveNull(): void
    {
        $builder = $this->factory->createBuilder();
        $builder->add('postcode', PostalCodeType::class, [
            'country_iso' => 'GB',
        ]);

        $form = $builder->getForm();

        $data = [
            'postcode' => 'INVALID',
        ];

        $form->submit($data);

        $expected = [
            'postcode' => null,
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
     * @covers \Brain\Common\Form\Type\Normalisation\PostalCodeType
     */
    public function withValidPostalCodeStandardise(): void
    {
        $builder = $this->factory->createBuilder();
        $builder->add('postcode', PostalCodeType::class, [
            'country_iso' => 'GB',
        ]);

        $form = $builder->getForm();

        $data = [
            'postcode' => 'W1W 5nq',
        ];

        $form->submit($data);

        $expected = [
            'postcode' => 'W1W5NQ',
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
     * @covers \Brain\Common\Form\Type\Normalisation\PostalCodeType
     */
    public function withValidPostalCodePriorityResolver(): void
    {
        $builder = $this->factory->createBuilder();
        $builder->add('postcode', PostalCodeType::class, [
            'country_iso' => 'NL',
            'country_iso_resolver' => function () {
                return 'GB';
            },
        ]);

        $form = $builder->getForm();

        $data = [
            'postcode' => 'W1W 5nq',
        ];

        $form->submit($data);

        $expected = [
            'postcode' => 'W1W5NQ',
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
     * @covers \Brain\Common\Form\Type\Normalisation\PostalCodeType
     */
    public function canCountryIsoResolveFromOtherField(): void
    {
        $builder = $this->factory->createBuilder();
        $builder->add('iso', TextType::class);
        $builder->add('postcode', PostalCodeType::class, [
            'country_iso_resolver' => function (FormInterface $form) {
                return $form->get('iso')->getData();
            },
        ]);

        $form = $builder->getForm();

        $data = [
            'iso' => 'NL',
            'postcode' => '2993 VD',
        ];

        $form->submit($data);

        $expected = [
            'iso' => 'NL',
            'postcode' => '2993VD',
        ];

        self::assertEquals($expected, $form->getData());
    }
}
