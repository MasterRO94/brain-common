<?php

namespace Brain\Common\Response;

use Brain\Common\Database\Pagination\Paginator;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use FOS\RestBundle\View\View;

/**
 * A response factory for creating view instances.
 *
 * @api
 */
class ResponseFactory
{
    /**
     * Create a view.
     *
     * @param Request $request
     * @param mixed $data
     * @param array $groups
     * @param int $status
     *
     * @return View
     */
    final public function view(Request $request, $data = [], array $groups, int $status): View
    {
        $groups = $this->prepareSerialisationGroups($groups);
        $response = $data;

        //  HEAD requests should be empty.
        if ($request->getMethod() === Request::METHOD_HEAD) {
            $response = null;
            $groups = null;
        }

        $view = View::create($this->prepare($response), $status);
        $view->getContext()->setGroups($groups);

        //  Add pagination headers.
        if ($data instanceof Paginator) {
            $view->setHeader(Paginator::PAGINATION_PAGE_TOTAL, $data->getNbPages());
            $view->setHeader(Paginator::PAGINATION_RESULTS, count($view->getData()));
            $view->setHeader(Paginator::PAGINATION_RESULTS_TOTAL, $data->getNbResults());
            $view->setHeader(Paginator::PAGINATION_RESULTS_PER_PAGE, $data->getMaxPerPage());
        }

        $view = $this->prepareResponseView($data, $request, $view);

        return $view;
    }

    /**
     * Prepare the view response.
     *
     * @param mixed $data
     * @param Request $request
     * @param View $view
     *
     * @return View
     */
    public function prepareResponseView($data, Request $request, View $view): View
    {
        $headers = $this->getCrossOriginHeaders($data, $request);

        foreach ($headers as $header => $value) {
            $view->setHeader($header, $value);
        }

        return $view;
    }

    /**
     * Prepare the symfony response.
     *
     * @param mixed $data
     * @param Request $request
     * @param Response $response
     *
     * @return Response
     */
    public function prepareResponse($data, Request $request, Response $response): Response
    {
        $headers = $this->getCrossOriginHeaders($data, $request);

        foreach ($headers as $header => $value) {
            $response->headers->set($header, $value, true);
        }

        return $response;
    }

    /**
     * Prepare serialisation groups.
     *
     * @param string[] $groups
     *
     * @return string[]
     *
     * @api
     */
    protected function prepareSerialisationGroups(array $groups): array
    {
        if (!in_array('global', $groups)) {
            $groups[] = 'global';
        }

        return $groups;
    }

    /**
     * For requests that are protected by this Cross Origin Domain stuff. Add in the headers required
     * so we can stop hammering our servers for options requests.
     *
     * @param mixed $data
     * @param Request $request
     *
     * @return string[]
     */
    private function getCrossOriginHeaders($data, Request $request): array
    {
        $origin = $request->headers->get('origin', '*');

        $expose = [
            'Authorization',
            'Content-Type',
            'Location',
            'Date',
        ];

        if ($data instanceof Paginator) {
            $expose[] = Paginator::PAGINATION_PAGE_TOTAL;
            $expose[] = Paginator::PAGINATION_RESULTS;
            $expose[] = Paginator::PAGINATION_RESULTS_TOTAL;
            $expose[] = Paginator::PAGINATION_RESULTS_PER_PAGE;
        }

        $methods = [
            Request::METHOD_OPTIONS,
            Request::METHOD_HEAD,
            Request::METHOD_GET,
            Request::METHOD_POST,
            Request::METHOD_PATCH,
            Request::METHOD_PUT,
            Request::METHOD_DELETE,
            'LINK',
            'UNLINK',
        ];

        return [
            'Access-Control-Allow-Origin' => $origin,
            'Access-Control-Allow-Headers' => implode(',', $expose),
            'Access-Control-Expose-Headers' => implode(',', $expose),
            'Access-Control-Allow-Methods' => implode(',', $methods),

            //  Don't request this endpoint for another hour.
            'Access-Control-Max-Age' => 60 * 60,
        ];
    }

    /**
     * Prepare the response.
     *
     * @param mixed $data
     *
     * @return mixed
     */
    private function prepare($data)
    {
        if ($data instanceof Paginator) {
            return $data->getIterator()->getArrayCopy();
        } else {
            return $data;
        }
    }
}
