<?php

declare(strict_types=1);

namespace Brain\Common\Response\Http;

use Symfony\Component\HttpFoundation\Response;

/**
 * {@inheritdoc}
 */
interface HttpResponseFactoryInterface extends HttpFactoryInterface
{
    /**
     * {@inheritdoc}
     *
     * @return Response
     */
    public function ok($data = null, array $groups = []): Response;

    /**
     * {@inheritdoc}
     *
     * @return Response
     */
    public function created($data, array $groups = []): Response;

    /**
     * {@inheritdoc}
     *
     * @return Response
     */
    public function noContent(): Response;

    /**
     * {@inheritdoc}
     *
     * @return Response
     */
    public function notModified(): Response;

    /**
     * {@inheritdoc}
     *
     * @return Response
     */
    public function badRequest($data, array $groups = []): Response;

    /**
     * {@inheritdoc}
     *
     * @return Response
     */
    public function notFound($data): Response;
}
