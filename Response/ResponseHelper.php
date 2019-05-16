<?php

declare(strict_types=1);

namespace Brain\Common\Response;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;

use FOS\RestBundle\View\View;

/**
 * A response helper for creating common view instances.
 *
 * @deprecated Use one of the HTTP Factories available.
 */
class ResponseHelper
{
    /** @var ResponseFactory */
    private $responseFactory;

    /** @var RequestStack */
    private $requestStack;

    public function __construct(ResponseFactory $responseFactory, RequestStack $requestStack)
    {
        $this->responseFactory = $responseFactory;
        $this->requestStack = $requestStack;
    }

    /**
     * Generate a response.
     *
     * @param mixed $data
     * @param string[] $groups
     */
    final public function generate(int $status, $data, array $groups = [], ?Request $request = null): View
    {
        $request = $request ?: $this->requestStack->getCurrentRequest();

        if ($request === null) {
            throw new \RuntimeException('A request was expected!');
        }

        return $this->responseFactory->view($request, $data, $groups, $status);
    }

    /**
     * Create an OK 200 response.
     *
     * @param mixed $data
     * @param string[] $groups
     */
    final public function ok($data = null, array $groups = []): View
    {
        return $this->generate(Response::HTTP_OK, $data, $groups);
    }

    /**
     * Create an OK 201 response.
     *
     * @param mixed $data
     * @param string[] $groups
     */
    final public function created($data, array $groups = []): View
    {
        return $this->generate(Response::HTTP_CREATED, $data, $groups);
    }

    /**
     * Create a No Content 204 response.
     */
    final public function noContent(): View
    {
        return $this->generate(Response::HTTP_NO_CONTENT, null);
    }

    /**
     * Create a NOT MODIFIED 304 response.
     */
    final public function notModified(): View
    {
        return $this->generate(Response::HTTP_NOT_MODIFIED, null);
    }

    /**
     * Create a Bad Request 400 response.
     *
     * @param mixed $data
     * @param string[] $groups
     */
    final public function badRequest($data, array $groups = []): View
    {
        return $this->generate(Response::HTTP_BAD_REQUEST, $data, $groups);
    }
}
