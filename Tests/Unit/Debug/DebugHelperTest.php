<?php

declare(strict_types=1);

namespace Brain\Common\Tests\Unit\Debug;

use Brain\Common\Debug\DebugHelper;
use Brain\Common\Tests\Fixture\Database\BasicEntityIdentityAwareTestFixture;
use Brain\Common\Tests\Fixture\Database\BasicEntityProxyTestFixture;
use Brain\Common\Tests\Fixture\Database\BasicEntityTestFixture;

use PHPUnit\Framework\TestCase;

/**
 * @group unit
 * @group debug
 *
 * @covers \Brain\Common\Debug\DebugHelper
 */
final class DebugHelperTest extends TestCase
{
    /**
     * @test
     */
    public function canRepresentBasicAsJustClassName(): void
    {
        $entity = new BasicEntityTestFixture();

        $representation = DebugHelper::represent($entity, [], false);

        $template = '%s{none}';
        $expected = sprintf($template, BasicEntityTestFixture::class);

        self::assertEquals($expected, $representation);
    }

    /**
     * @test
     */
    public function canRepresentBasicAsJustClassNameShortName(): void
    {
        $entity = new BasicEntityTestFixture();

        $representation = DebugHelper::represent($entity, [], true);

        $expected = 'BasicEntityTestFixture{none}';

        self::assertEquals($expected, $representation);
    }

    /**
     * @test
     */
    public function canRepresentBasicAsJustClassNameWithData(): void
    {
        $entity = new BasicEntityTestFixture();

        $data = [
            'a' => 'b',
            'c' => 1,
            'd' => false,
            'f' => null,
            'e' => [],
        ];

        $representation = DebugHelper::represent($entity, $data, false);

        $template = '%s{a="b", c=1, d=false, f=null}';
        $expected = sprintf($template, BasicEntityTestFixture::class);

        self::assertEquals($expected, $representation);
    }

    /**
     * @test
     */
    public function canRepresentBasicAsJustClassNameWithDataShortName(): void
    {
        $entity = new BasicEntityTestFixture();

        $data = [
            'a' => 'b',
            'c' => 1,
            'd' => false,
            'f' => null,
            'e' => [],
        ];

        $representation = DebugHelper::represent($entity, $data, true);

        $expected = 'BasicEntityTestFixture{a="b", c=1, d=false, f=null}';

        self::assertEquals($expected, $representation);
    }

    /**
     * @test
     */
    public function canRepresentIdentityAware(): void
    {
        $entity = new BasicEntityIdentityAwareTestFixture();
        $entity->setId(123);

        $representation = DebugHelper::represent($entity, [], false);

        $template = '%s{id=123}';
        $expected = sprintf($template, BasicEntityIdentityAwareTestFixture::class);

        self::assertEquals($expected, $representation);
    }

    /**
     * @test
     */
    public function canRepresentIdentityAwareShortName(): void
    {
        $entity = new BasicEntityIdentityAwareTestFixture();
        $entity->setId(123);

        $representation = DebugHelper::represent($entity, [], true);

        $expected = 'BasicEntityIdentityAwareTestFixture{id=123}';

        self::assertEquals($expected, $representation);
    }

    /**
     * @test
     */
    public function canRepresentIdentityAwareWithData(): void
    {
        $entity = new BasicEntityIdentityAwareTestFixture();
        $entity->setId(123);

        $data = [
            'a' => 'b',
            'c' => true,
        ];

        $representation = DebugHelper::represent($entity, $data, false);

        $template = '%s{id=123, a="b", c=true}';
        $expected = sprintf($template, BasicEntityIdentityAwareTestFixture::class);

        self::assertEquals($expected, $representation);
    }

    /**
     * @test
     */
    public function canRepresentIdentityAwareWithDataShortName(): void
    {
        $entity = new BasicEntityIdentityAwareTestFixture();
        $entity->setId(123);

        $data = [
            'a' => 'b',
            'c' => true,
        ];

        $representation = DebugHelper::represent($entity, $data, true);

        $expected = 'BasicEntityIdentityAwareTestFixture{id=123, a="b", c=true}';

        self::assertEquals($expected, $representation);
    }

    /**
     * @test
     */
    public function canRepresentIdentityAwareNoIdentity(): void
    {
        $entity = new BasicEntityIdentityAwareTestFixture();

        $representation = DebugHelper::represent($entity, [], false);

        $template = '%s{id=null}';
        $expected = sprintf($template, BasicEntityIdentityAwareTestFixture::class);

        self::assertEquals($expected, $representation);
    }

    /**
     * @test
     */
    public function canRepresentIdentityAwareNoIdentityShortName(): void
    {
        $entity = new BasicEntityIdentityAwareTestFixture();

        $representation = DebugHelper::represent($entity, [], true);

        $expected = 'BasicEntityIdentityAwareTestFixture{id=null}';

        self::assertEquals($expected, $representation);
    }

    /**
     * @test
     */
    public function canRepresentProxy(): void
    {
        $entity = new BasicEntityProxyTestFixture();

        $representation = DebugHelper::represent($entity, [], false);

        $template = '%s{none}';
        $expected = sprintf($template, BasicEntityTestFixture::class);

        self::assertEquals($expected, $representation);
    }

    /**
     * @test
     */
    public function canRepresentProxyShortName(): void
    {
        $entity = new BasicEntityProxyTestFixture();

        $representation = DebugHelper::represent($entity, [], true);

        $expected = 'BasicEntityTestFixture{none}';

        self::assertEquals($expected, $representation);
    }

    /**
     * @test
     */
    public function canRepresentProxyWithData(): void
    {
        $entity = new BasicEntityProxyTestFixture();

        $data = [
            'a' => 'b',
        ];

        $representation = DebugHelper::represent($entity, $data, false);

        $template = '%s{a="b"}';
        $expected = sprintf($template, BasicEntityTestFixture::class);

        self::assertEquals($expected, $representation);
    }

    /**
     * @test
     */
    public function canRepresentProxyWithDataShortName(): void
    {
        $entity = new BasicEntityProxyTestFixture();

        $data = [
            'a' => 'b',
        ];

        $representation = DebugHelper::represent($entity, $data, true);

        $expected = 'BasicEntityTestFixture{a="b"}';

        self::assertEquals($expected, $representation);
    }
}
