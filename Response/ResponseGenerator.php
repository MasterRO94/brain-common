<?php

declare(strict_types=1);

namespace Brain\Common\Response;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;

use FOS\RestBundle\View\View;
use RuntimeException;

/**
 * A response generator helper.
 */
final class ResponseGenerator
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
     * Generate a view response.
     *
     * @param mixed $data
     * @param string[] $groups
     */
    public function generateView(int $status, $data, array $groups = [], ?Request $request = null): View
    {
        $request = $request ?: $this->requestStack->getCurrentRequest();

        if ($request === null) {
            throw new RuntimeException('A request was expected!');
        }

        return $this->responseFactory->view($request, $data, $groups, $status);
    }

    /**
     * Generate a response.
     *
     * @param mixed $data
     * @param string[] $groups
     */
    public function generateResponse(int $status, $data, array $groups = [], ?Request $request = null): Response
    {
        $request = $request ?: $this->requestStack->getCurrentRequest();

        if ($request === null) {
            throw new RuntimeException('A request was expected!');
        }

        $view = $this->responseFactory->view($request, $data, $groups, $status);

        // View does come prepared so lets prepare it before we return it.
        $response = $view->getResponse();
        $response->setContent(json_encode($view->getData()));
        $response->setStatusCode($status);

        return $response;
    }
}
