<?php

namespace Brain\Common\Response\Http;

use Brain\Common\Response\ResponseGenerator;

use Symfony\Component\HttpFoundation\Response;

/**
 * {@inheritdoc}
 */
final class HttpResponseFactory implements HttpFactoryInterface
{
    private $generator;

    /**
     * Constructor.
     *
     * @param ResponseGenerator $generator
     */
    public function __construct(ResponseGenerator $generator)
    {
        $this->generator = $generator;
    }

    /**
     * {@inheritdoc}
     *
     * @return Response
     */
    public function ok($data = null, array $groups = []): Response
    {
        return $this->generator->generateResponse(Response::HTTP_OK, $data, $groups);
    }

    /**
     * {@inheritdoc}
     *
     * @return Response
     */
    public function created($data, array $groups = []): Response
    {
        return $this->generator->generateResponse(Response::HTTP_CREATED, $data, $groups);
    }

    /**
     * {@inheritdoc}
     *
     * @return Response
     */
    public function noContent(): Response
    {
        return $this->generator->generateResponse(Response::HTTP_NO_CONTENT, null);
    }

    /**
     * {@inheritdoc}
     *
     * @return Response
     */
    public function notModified(): Response
    {
        return $this->generator->generateResponse(Response::HTTP_NOT_MODIFIED, null);
    }

    /**
     * {@inheritdoc}
     *
     * @param mixed $data
     * @param array $groups
     *
     * @return Response
     */
    public function badRequest($data, array $groups = []): Response
    {
        return $this->generator->generateResponse(Response::HTTP_BAD_REQUEST, $data, $groups);
    }
}
