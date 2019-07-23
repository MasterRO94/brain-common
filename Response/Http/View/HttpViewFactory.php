<?php

declare(strict_types=1);

namespace Brain\Common\Response\Http\View;

use Brain\Common\Response\Http\HttpViewFactoryInterface;
use Brain\Common\Response\ResponseGenerator;

use Symfony\Component\HttpFoundation\Response;

use FOS\RestBundle\View\View;

/**
 * {@inheritdoc}
 */
final class HttpViewFactory implements HttpViewFactoryInterface
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
    public function ok($data = null, array $groups = []): View
    {
        return $this->generator->generateView(Response::HTTP_OK, $data, $groups);
    }

    /**
     * {@inheritdoc}
     */
    public function created($data, array $groups = []): View
    {
        return $this->generator->generateView(Response::HTTP_CREATED, $data, $groups);
    }

    /**
     * {@inheritdoc}
     */
    public function noContent(): View
    {
        return $this->generator->generateView(Response::HTTP_NO_CONTENT, null);
    }

    /**
     * {@inheritdoc}
     */
    public function notModified(): View
    {
        return $this->generator->generateView(Response::HTTP_NOT_MODIFIED, null);
    }

    /**
     * {@inheritdoc}
     */
    public function badRequest($data, array $groups = []): View
    {
        return $this->generator->generateView(Response::HTTP_BAD_REQUEST, $data, $groups);
    }

    /**
     * {@inheritdoc}
     */
    public function notFound($data): View
    {
        return $this->generator->generateView(Response::HTTP_NOT_FOUND, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function notAcceptable($data): View
    {
        return $this->generator->generateView(Response::HTTP_NOT_ACCEPTABLE, $data);
    }
}
