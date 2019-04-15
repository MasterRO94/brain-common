<?php

declare(strict_types=1);

namespace Brain\Common\Response;

use Brain\Common\Database\Pagination\Paginator;
use Brain\Common\Serializer\SerializerFactory;
use Brain\Common\Serializer\SerializerFactoryHelper;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use FOS\RestBundle\View\View;

/**
 * A response factory for creating view instances.
 */
class ResponseFactory
{
    private $factory;

    public function __construct(?SerializerFactory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * Create a view.
     *
     * @param mixed $data
     * @param string[] $groups
     */
    final public function view(Request $request, $data, array $groups, int $status): View
    {
        $groups = $this->prepareSerialisationGroups($groups);
        $response = $data;

        // HEAD requests should be empty.
        if ($request->getMethod() === Request::METHOD_HEAD) {
            $response = null;
            $groups = null;
        }

        $response = $this->prepare($response);

        // This is a result of JMS being probably the most awful thing on the planet.
        // The serializer doesn't return what is returned from handlers.
        // In this case ignore the serializer and construct a navigator.
        if ($this->factory instanceof SerializerFactory && $this->isValid($response)) {
            $response = SerializerFactoryHelper::serialize($this->factory, $response, $groups);
        }

        $view = View::create($response, $status);
        $view->getContext()->setGroups($groups);

        // Add pagination headers.
        if ($data instanceof Paginator) {
            $view->setHeader(Paginator::PAGINATION_PAGE_TOTAL, (string) $data->getNbPages());
            $view->setHeader(Paginator::PAGINATION_RESULTS, (string) count($view->getData()));
            $view->setHeader(Paginator::PAGINATION_RESULTS_TOTAL, (string) $data->getNbResults());
            $view->setHeader(Paginator::PAGINATION_RESULTS_PER_PAGE, (string) $data->getMaxPerPage());
        }

        $view = $this->prepareResponseView($data, $request, $view);

        return $view;
    }

    /**
     * Prepare the view response.
     *
     * @param mixed $data
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
     *
     * @return string[]
     */
    private function getCrossOriginHeaders($data, Request $request): array
    {
        /** @var string $origin */
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

            // Don't request this endpoint for another hour.
            'Access-Control-Max-Age' => (string) (60 * 60),
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
            $data = $data->getIterator()->getArrayCopy();
        }

        return $data;
    }

    /**
     * Check the data is valid.
     *
     * @param mixed $data
     */
    private function isValid($data): bool
    {
        return is_array($data)
            || is_object($data);
    }
}
