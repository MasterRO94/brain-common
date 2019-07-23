<?php

declare(strict_types=1);

namespace Brain\Common\Tests\Unit\Response\Http\Response;

use Brain\Bundle\Core\Enum\HttpStatusEnum;

use Brain\Common\Response\Http\Response\HttpResponseFactory;
use Brain\Common\Response\ResponseFactory;
use Brain\Common\Response\ResponseGenerator;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * @group unit
 * @group common
 * @group response
 *
 * @covers \Brain\Common\Response\Http\Response\HttpResponseFactory
 */
final class HttpResponseFactoryTest extends TestCase
{
    /**
     * @test
     */
    public function canCreateOk(): void
    {
        $request = new Request();

        /** @var RequestStack|MockObject $stack */
        $stack = $this->createMock(RequestStack::class);
        $stack->expects(self::once())
            ->method('getCurrentRequest')
            ->willReturn($request);

        $factory = new HttpResponseFactory(
            new ResponseGenerator(
                new ResponseFactory(null),
                $stack
            )
        );

        $response = $factory->ok([
            'blarp' => 'floot',
        ]);

        self::assertEquals(HttpStatusEnum::HTTP_OK, $response->getStatusCode());
        self::assertEquals('{"blarp":"floot"}', $response->getContent());
    }

    /**
     * @test
     */
    public function canCreateCreated(): void
    {
        $request = new Request();

        /** @var RequestStack|MockObject $stack */
        $stack = $this->createMock(RequestStack::class);
        $stack->expects(self::once())
            ->method('getCurrentRequest')
            ->willReturn($request);

        $factory = new HttpResponseFactory(
            new ResponseGenerator(
                new ResponseFactory(null),
                $stack
            )
        );

        $response = $factory->created([
            'bart' => 'foop',
        ]);

        self::assertEquals(HttpStatusEnum::HTTP_CREATED, $response->getStatusCode());
        self::assertEquals('{"bart":"foop"}', $response->getContent());
    }

    /**
     * @test
     */
    public function canCreateNoContent(): void
    {
        $request = new Request();

        /** @var RequestStack|MockObject $stack */
        $stack = $this->createMock(RequestStack::class);
        $stack->expects(self::once())
            ->method('getCurrentRequest')
            ->willReturn($request);

        $factory = new HttpResponseFactory(
            new ResponseGenerator(
                new ResponseFactory(null),
                $stack
            )
        );

        $response = $factory->noContent();

        self::assertEquals(HttpStatusEnum::HTTP_NO_CONTENT, $response->getStatusCode());
        self::assertEquals('null', $response->getContent());
    }

    /**
     * @test
     */
    public function canCreateNotModified(): void
    {
        $request = new Request();

        /** @var RequestStack|MockObject $stack */
        $stack = $this->createMock(RequestStack::class);
        $stack->expects(self::once())
            ->method('getCurrentRequest')
            ->willReturn($request);

        $factory = new HttpResponseFactory(
            new ResponseGenerator(
                new ResponseFactory(null),
                $stack
            )
        );

        $response = $factory->notModified();

        self::assertEquals(HttpStatusEnum::HTTP_NOT_MODIFIED, $response->getStatusCode());
        self::assertEquals('null', $response->getContent());
    }

    /**
     * @test
     */
    public function canCreateBadRequest(): void
    {
        $request = new Request();

        /** @var RequestStack|MockObject $stack */
        $stack = $this->createMock(RequestStack::class);
        $stack->expects(self::once())
            ->method('getCurrentRequest')
            ->willReturn($request);

        $factory = new HttpResponseFactory(
            new ResponseGenerator(
                new ResponseFactory(null),
                $stack
            )
        );

        $response = $factory->badRequest([
            'foob' => 'barp',
        ]);

        self::assertEquals(HttpStatusEnum::HTTP_BAD_REQUEST, $response->getStatusCode());
        self::assertEquals('{"foob":"barp"}', $response->getContent());
    }

    /**
     * @test
     */
    public function canCreateNotFound(): void
    {
        $request = new Request();

        /** @var RequestStack|MockObject $stack */
        $stack = $this->createMock(RequestStack::class);
        $stack->expects(self::once())
            ->method('getCurrentRequest')
            ->willReturn($request);

        $factory = new HttpResponseFactory(
            new ResponseGenerator(
                new ResponseFactory(null),
                $stack
            )
        );

        $response = $factory->notFound([
            'foo' => 'bar',
        ]);

        self::assertEquals(HttpStatusEnum::HTTP_NOT_FOUND, $response->getStatusCode());
        self::assertEquals('{"foo":"bar"}', $response->getContent());
    }

    /**
     * @test
     */
    public function canCreateNotAcceptable(): void
    {
        $request = new Request();

        /** @var RequestStack|MockObject $stack */
        $stack = $this->createMock(RequestStack::class);
        $stack->expects(self::once())
            ->method('getCurrentRequest')
            ->willReturn($request);

        $factory = new HttpResponseFactory(
            new ResponseGenerator(
                new ResponseFactory(null),
                $stack
            )
        );

        $response = $factory->notAcceptable([
            'foo' => 'bar',
            'tony' => 'stark',
        ]);

        self::assertEquals(HttpStatusEnum::HTTP_NOT_ACCEPTABLE, $response->getStatusCode());
        self::assertEquals('{"foo":"bar","tony":"stark"}', $response->getContent());
    }
}
