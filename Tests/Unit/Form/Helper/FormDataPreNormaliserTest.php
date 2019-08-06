<?php

declare(strict_types=1);

namespace Brain\Common\Tests\Unit\Form\Helper;

use Brain\Common\Form\Helper\FormDataPreNormaliser;
use Brain\Common\Form\Type\Entity\EntityLookupDefinition;

use PHPUnit\Framework\TestCase;

/**
 * {@inheritdoc}
 */
final class FormDataPreNormaliserTest extends TestCase
{
    public const EXAMPLE_UUID = '08275c6b-2e31-39f6-b5fa-afa91feb66b0';
    public const EXAMPLE_ALIAS = 'some-alias';

    /**
     * @test
     *
     * @group bundle
     * @group core
     *
     * @covers \Brain\Common\Form\Helper\FormDataPreNormaliser
     */
    public function canNormaliseStringIdentity(): void
    {
        $normalised = FormDataPreNormaliser::normalise(self::EXAMPLE_UUID);

        $expected = [
            'id' => self::EXAMPLE_UUID,
            'alias' => null,
        ];

        self::assertEquals($expected, $normalised);
    }

    /**
     * @test
     *
     * @group bundle
     * @group core
     *
     * @covers \Brain\Common\Form\Helper\FormDataPreNormaliser
     */
    public function canNormaliseStringAlias(): void
    {
        $normalised = FormDataPreNormaliser::normalise(self::EXAMPLE_ALIAS);

        $expected = [
            'id' => null,
            'alias' => self::EXAMPLE_ALIAS,
        ];

        self::assertEquals($expected, $normalised);
    }

    /**
     * @test
     *
     * @group bundle
     * @group core
     *
     * @covers \Brain\Common\Form\Helper\FormDataPreNormaliser
     */
    public function canNormaliseArrayIdentity(): void
    {
        $normalised = FormDataPreNormaliser::normalise([
            'id' => self::EXAMPLE_UUID,
        ]);

        $expected = [
            'id' => self::EXAMPLE_UUID,
            'alias' => null,
        ];

        self::assertEquals($expected, $normalised);
    }

    /**
     * @test
     *
     * @group bundle
     * @group core
     *
     * @covers \Brain\Common\Form\Helper\FormDataPreNormaliser
     */
    public function canNormaliseArrayAlias(): void
    {
        $normalised = FormDataPreNormaliser::normalise([
            'alias' => self::EXAMPLE_ALIAS,
        ]);

        $expected = [
            'id' => null,
            'alias' => self::EXAMPLE_ALIAS,
        ];

        self::assertEquals($expected, $normalised);
    }

    /**
     * @test
     *
     * @group bundle
     * @group core
     *
     * @covers \Brain\Common\Form\Helper\FormDataPreNormaliser
     */
    public function canNormaliseCombination(): void
    {
        $normalised = FormDataPreNormaliser::normalise([
            'id' => self::EXAMPLE_UUID,
            'alias' => self::EXAMPLE_ALIAS,
        ]);

        $expected = [
            'id' => self::EXAMPLE_UUID,
            'alias' => self::EXAMPLE_ALIAS,
        ];

        self::assertEquals($expected, $normalised);
    }

    /**
     * @test
     *
     * @group bundle
     * @group core
     *
     * @covers \Brain\Common\Form\Helper\FormDataPreNormaliser
     */
    public function canNormaliseCombinationExtraData(): void
    {
        $normalised = FormDataPreNormaliser::normalise([
            'id' => self::EXAMPLE_UUID,
            'alias' => self::EXAMPLE_ALIAS,
            'foo' => 'bar',
        ]);

        $expected = [
            'id' => self::EXAMPLE_UUID,
            'alias' => self::EXAMPLE_ALIAS,
            'foo' => 'bar',
        ];

        self::assertEquals($expected, $normalised);
    }

    /**
     * Data provider.
     *
     * @return mixed[]
     */
    public function provideCanNormaliseForMapping(): array
    {
        return [

            'single-null' => [
                [
                    'id' => null,
                ],
                null,
                [
                    'id' => EntityLookupDefinition::create('example'),
                ],
            ],

            'many-null' => [
                [
                    'id' => null,
                    'alias' => null,
                ],
                null,
                [
                    'id' => EntityLookupDefinition::create('example'),
                    'alias' => EntityLookupDefinition::create('example'),
                ],
            ],

            'custom-null' => [
                [
                    'id' => null,
                    'alias' => 'default',
                ],
                null,
                [
                    'id' => EntityLookupDefinition::create('example'),
                    'alias' => EntityLookupDefinition::create('example', 'default'),
                ],
            ],

            'array-merge' => [
                [
                    'id' => 1,
                    'data' => 'example',
                ],
                [
                    'id' => 1,
                    'data' => 'example',
                ],
                [
                    'id' => EntityLookupDefinition::create('example'),
                ],
            ],

            'meets-regex' => [
                [
                    'id' => '1-1',
                ],
                '1-1',
                [
                    'id' => EntityLookupDefinition::create('example')->setRegex('/^1/'),
                ],
            ],

            'meets-regex-priority' => [
                [
                    'id' => '1-1',
                    'alias' => null,
                ],
                '1-1',
                [
                    'id' => EntityLookupDefinition::create('example')->setRegex('/^1/'),
                    'alias' => EntityLookupDefinition::create('example')->setRegex('/^1/'),
                ],
            ],

            'meets-regex-priority-2' => [
                [
                    'id' => null,
                    'alias' => '1-1',
                ],
                '1-1',
                [
                    'id' => EntityLookupDefinition::create('example')->setRegex('/^2/'),
                    'alias' => EntityLookupDefinition::create('example'),
                ],
            ],

            'allow-invalid-single-entry' => [
                [
                    'id' => 'invalid-id',
                ],
                'invalid-id',
                [
                    'id' => EntityLookupDefinition::create('example')->setRegex('/^2/'),
                ],
            ],

            'allow-invalid-specified' => [
                [
                    'id' => 'invalid-id',
                ],
                [
                    'id' => 'invalid-id',
                ],
                [
                    'id' => EntityLookupDefinition::create('example')->setRegex('/^2/'),
                ],
            ],

            'allow-invalid-add-missing' => [
                [
                    'id' => 'invalid-id',
                    'alias' => null,
                ],
                [
                    'id' => 'invalid-id',
                ],
                [
                    'id' => EntityLookupDefinition::create('example')->setRegex('/^2/'),
                    'alias' => EntityLookupDefinition::create('example'),
                ],
            ],

        ];
    }

    /**
     * @test
     * @dataProvider provideCanNormaliseForMapping
     *
     * @param mixed[] $expected
     * @param mixed[]|string|null $data
     * @param EntityLookupDefinition[] $definitions
     *
     * @covers \Brain\Common\Form\Helper\FormDataPreNormaliser
     */
    public function canNormaliseForMapping(array $expected, $data, array $definitions): void
    {
        $normalised = FormDataPreNormaliser::normaliseForMappedColumns($data, $definitions);
        self::assertEquals($expected, $normalised);
    }

    /**
     * @test
     */
    public function withNullFormDataHasKeyReturnFalse(): void
    {
        self::assertFalse(FormDataPreNormaliser::hasFormDataKey(null, 'foo'));
    }

    /**
     * @test
     */
    public function withArrayButMissingKeyFormDataHasKeyReturnFalse(): void
    {
        self::assertFalse(FormDataPreNormaliser::hasFormDataKey([], 'foo'));
    }

    /**
     * @test
     */
    public function canDetectFormDataHasKey(): void
    {
        $array = [
            'foo' => 'bar',
        ];

        self::assertTrue(FormDataPreNormaliser::hasFormDataKey($array, 'foo'));
    }
}
