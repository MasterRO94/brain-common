<?php

declare(strict_types=1);

namespace Brain\Common\Tests\Unit\Form\Type\Enum;

use Brain\Common\Form\Type\Enum\EnumType;
use Brain\Common\Tests\Fixture\Enum\ExampleTestFixtureEnum;

use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Test\TypeTestCase;

/**
 * @group unit
 * @group form
 *
 * @covers \Brain\Common\Form\Type\Enum\EnumType
 */
final class EnumTypeTest extends TypeTestCase
{
    /**
     * @test
     */
    public function whenNotSpecifiedResolveNull(): void
    {
        $builder = $this->factory->createBuilder();
        $builder->add('enum', EnumType::class, [
            'enum' => ExampleTestFixtureEnum::class,
        ]);

        $form = $builder->getForm();

        $data = [];

        $form->submit($data);

        $expected = [
            'enum' => null,
        ];

        self::assertEquals($expected, $form->getData());
    }

    /**
     * @test
     */
    public function withEmptyValueResolveNull(): void
    {
        $builder = $this->factory->createBuilder();
        $builder->add('enum', EnumType::class, [
            'enum' => ExampleTestFixtureEnum::class,
        ]);

        $form = $builder->getForm();

        $data = [
            'enum' => '',
        ];

        $form->submit($data);

        $expected = [
            'enum' => null,
        ];

        self::assertEquals($expected, $form->getData());
    }

    /**
     * @test
     */
    public function withNullValueResolveNull(): void
    {
        $builder = $this->factory->createBuilder();
        $builder->add('enum', EnumType::class, [
            'enum' => ExampleTestFixtureEnum::class,
        ]);

        $form = $builder->getForm();

        $data = [
            'enum' => null,
        ];

        $form->submit($data);

        $expected = [
            'enum' => null,
        ];

        self::assertEquals($expected, $form->getData());
    }

    /**
     * @test
     */
    public function withInvalidValueResolveNull(): void
    {
        $builder = $this->factory->createBuilder();
        $builder->add('enum', EnumType::class, [
            'enum' => ExampleTestFixtureEnum::class,
        ]);

        $form = $builder->getForm();

        $data = [
            'enum' => 123,
        ];

        $form->submit($data);

        $expected = [
            'enum' => null,
        ];

        self::assertEquals($expected, $form->getData());
    }

    /**
     * @test
     */
    public function withValueButNotTranslationResolveNull(): void
    {
        $builder = $this->factory->createBuilder();
        $builder->add('enum', EnumType::class, [
            'enum' => ExampleTestFixtureEnum::class,
        ]);

        $form = $builder->getForm();

        $data = [
            'enum' => ExampleTestFixtureEnum::EXAMPLE_VALID,
        ];

        $form->submit($data);

        $expected = [
            'enum' => null,
        ];

        self::assertEquals($expected, $form->getData());
    }

    /**
     * @test
     */
    public function withTranslationResolveValue(): void
    {
        $builder = $this->factory->createBuilder();
        $builder->add('enum', EnumType::class, [
            'enum' => ExampleTestFixtureEnum::class,
        ]);

        $form = $builder->getForm();

        $data = [
            'enum' => ExampleTestFixtureEnum::translate(ExampleTestFixtureEnum::EXAMPLE_VALID),
        ];

        $form->submit($data);

        $expected = [
            'enum' => ExampleTestFixtureEnum::EXAMPLE_VALID,
        ];

        self::assertEquals($expected, $form->getData());
    }

    /**
     * @test
     */
    public function withExistingDataTransform(): void
    {
        $existing = [
            'enum' => ExampleTestFixtureEnum::EXAMPLE_NORMAL,
        ];

        $builder = $this->factory->createBuilder(FormType::class, $existing);
        $builder->add('enum', EnumType::class, [
            'enum' => ExampleTestFixtureEnum::class,
        ]);

        $form = $builder->getForm();

        $expected = [
            'enum' => ExampleTestFixtureEnum::EXAMPLE_NORMAL,
        ];

        self::assertEquals($expected, $form->getData());

        $form->submit([
            'enum' => ExampleTestFixtureEnum::translate(ExampleTestFixtureEnum::EXAMPLE_VALID),
        ]);

        $expected = [
            'enum' => ExampleTestFixtureEnum::EXAMPLE_VALID,
        ];

        self::assertEquals($expected, $form->getData());
    }
}
