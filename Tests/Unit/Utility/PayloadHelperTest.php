<?php

declare(strict_types=1);

namespace Brain\Common\Tests\Unit\Utility;

use Brain\Common\Utility\PayloadHelper;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * {@inheritdoc}
 */
class PayloadHelperTest extends TestCase
{
    /**
     * @test
     *
     * @group bundle
     * @group unit
     * @group core
     *
     * @covers \Brain\Common\Utility\PayloadHelper
     */
    public function canReadRequest(): void
    {
        /** @var MockObject|Request $request */
        $request = $this->createPartialMock(Request::class, ['getContent']);
        $request->expects(self::once())
            ->method('getContent')
            ->willReturn('{"hello":"world"}');

        $payload = PayloadHelper::getJsonFromRequest($request);

        $expected = [
            'hello' => 'world',
        ];

        self::assertEquals($expected, $payload);
    }

    /**
     * @test
     *
     * @group bundle
     * @group unit
     * @group core
     *
     * @covers \Brain\Common\Utility\PayloadHelper
     */
    public function canReadResponse(): void
    {
        /** @var MockObject|Response $response */
        $response = $this->createPartialMock(Response::class, ['getContent']);
        $response->expects(self::once())
            ->method('getContent')
            ->willReturn('{"hello":"world"}');

        $payload = PayloadHelper::getJsonFromResponse($response);

        $expected = [
            'hello' => 'world',
        ];

        self::assertEquals($expected, $payload);
    }

    /**
     * Data provider.
     *
     * @return mixed[][]
     */
    public function provideCanHandleJsonStrings(): array
    {
        return [

            'empty' => [
                '',
                [],
            ],

            'invalid' => [
                '[:]',
                [],
            ],

            'string' => [
                '"string"',
                [],
            ],

            'null' => [
                'null',
                [],
            ],

            'numeric' => [
                '123',
                [],
            ],

            'empty-array' => [
                '[]',
                [],
            ],

            'empty-object' => [
                '{}',
                [],
            ],

            'valid-object' => [
                '{"hello":"world"}',
                [
                    'hello' => 'world',
                ],
            ],

            'valid-collection' => [
                '[1,2,3]',
                [
                    1,
                    2,
                    3,
                ],
            ],

        ];
    }

    /**
     * @test
     * @dataProvider provideCanHandleJsonStrings
     *
     * @group bundle
     * @group unit
     * @group core
     *
     * @covers \Brain\Common\Utility\PayloadHelper
     *
     * @param mixed[][] $expected
     */
    public function canHandleJsonStrings(string $json, array $expected): void
    {
        $payload = PayloadHelper::json($json);
        self::assertEquals($expected, $payload);
    }
}
