<?php

namespace Brain\Common\Response\Http;

use Symfony\Component\HttpFoundation\Response;

use FOS\RestBundle\View\View;

interface HttpFactoryInterface
{
    /**
     * Create an OK 200 response.
     *
     * @param mixed $data
     * @param array $groups
     *
     * @return Response|View
     */
    public function ok($data = null, array $groups = []);

    /**
     * Create an OK 201 response.
     *
     * @param mixed $data
     * @param array $groups
     *
     * @return Response|View
     */
    public function created($data, array $groups = []);

    /**
     * Create a No Content 204 response.
     *
     * @return Response|View
     */
    public function noContent();

    /**
     * Create a NOT MODIFIED 304 response.
     *
     * @return Response|View
     */
    public function notModified();

    /**
     * Create a Bad Request 400 response.
     *
     * @param mixed $data
     * @param array $groups
     *
     * @return Response|View
     */
    public function badRequest($data, array $groups = []);
}
