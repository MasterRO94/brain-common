<?php

namespace Brain\Common\Response;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;

use FOS\RestBundle\View\View;

/**
 * A response generator helper.
 */
final class ResponseGenerator
{
    private $responseFactory;
    private $requestStack;

    /**
     * Constructor.
     *
     * @param ResponseFactory $responseFactory
     * @param RequestStack $requestStack
     */
    public function __construct(ResponseFactory $responseFactory, RequestStack $requestStack)
    {
        $this->responseFactory = $responseFactory;
        $this->requestStack = $requestStack;
    }

    /**
     * Generate a view response.
     *
     * @param int $status
     * @param mixed $data
     * @param string[] $groups
     * @param Request|null $request
     *
     * @return View
     */
    public function generateView(int $status, $data, array $groups = [], Request $request = null): View
    {
        $request = $request ?: $this->requestStack->getCurrentRequest();

        return $this->responseFactory->view($request, $data, $groups, $status);
    }

    /**
     * Generate a response.
     *
     * @param int $status
     * @param mixed $data
     * @param string[] $groups
     * @param Request|null $request
     *
     * @return Response
     */
    public function generateResponse(int $status, $data, array $groups = [], Request $request = null): Response
    {
        $request = $request ?: $this->requestStack->getCurrentRequest();

        return $this->responseFactory->view($request, $data, $groups, $status)->getResponse();
    }
}
