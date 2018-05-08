<?php

namespace Brain\Common\Response\Http;

use Brain\Common\Response\ResponseGenerator;

use Symfony\Component\HttpFoundation\Response;

use FOS\RestBundle\View\View;

/**
 * {@inheritdoc}
 */
final class HttpViewFactory implements HttpFactoryInterface
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
     * @return View
     */
    public function ok($data = null, array $groups = []): View
    {
        return $this->generator->generateView(Response::HTTP_OK, $data, $groups);
    }

    /**
     * {@inheritdoc}
     *
     * @return View
     */
    public function created($data, array $groups = []): View
    {
        return $this->generator->generateView(Response::HTTP_CREATED, $data, $groups);
    }

    /**
     * {@inheritdoc}
     *
     * @return View
     */
    public function noContent(): View
    {
        return $this->generator->generateView(Response::HTTP_NO_CONTENT, null);
    }

    /**
     * {@inheritdoc}
     *
     * @return View
     */
    public function notModified(): View
    {
        return $this->generator->generateView(Response::HTTP_NOT_MODIFIED, null);
    }

    /**
     * {@inheritdoc}
     *
     * @param mixed $data
     * @param array $groups
     *
     * @return View
     */
    public function badRequest($data, array $groups = []): View
    {
        return $this->generator->generateView(Response::HTTP_BAD_REQUEST, $data, $groups);
    }
}
