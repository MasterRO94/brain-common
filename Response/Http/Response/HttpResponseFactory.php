<?php

declare(strict_types=1);

namespace Brain\Common\Response\Http\Response;

use Brain\Common\Response\Http\HttpResponseFactoryInterface;
use Brain\Common\Response\ResponseGenerator;

use Symfony\Component\HttpFoundation\Response;

/**
 * {@inheritdoc}
 */
final class HttpResponseFactory implements HttpResponseFactoryInterface
{
    /** @var ResponseGenerator */
    private $generator;

    public function __construct(ResponseGenerator $generator)
    {
        $this->generator = $generator;
    }

    /**
     * {@inheritdoc}
     */
    public function ok($data = null, array $groups = []): Response
    {
        return $this->generator->generateResponse(Response::HTTP_OK, $data, $groups);
    }

    /**
     * {@inheritdoc}
     */
    public function created($data, array $groups = []): Response
    {
        return $this->generator->generateResponse(Response::HTTP_CREATED, $data, $groups);
    }

    /**
     * {@inheritdoc}
     */
    public function noContent(): Response
    {
        return $this->generator->generateResponse(Response::HTTP_NO_CONTENT, null);
    }

    /**
     * {@inheritdoc}
     */
    public function notModified(): Response
    {
        return $this->generator->generateResponse(Response::HTTP_NOT_MODIFIED, null);
    }

    /**
     * {@inheritdoc}
     */
    public function badRequest($data, array $groups = []): Response
    {
        return $this->generator->generateResponse(Response::HTTP_BAD_REQUEST, $data, $groups);
    }

    /**
     * {@inheritdoc}
     */
    public function notFound($data): Response
    {
        return $this->generator->generateResponse(Response::HTTP_NOT_FOUND, $data);
    }
}
