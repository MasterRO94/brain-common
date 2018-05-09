<?php

namespace Brain\Common\Response\Http;

use FOS\RestBundle\View\View;

/**
 * {@inheritdoc}
 */
interface HttpViewFactoryInterface extends HttpFactoryInterface
{
    /**
     * {@inheritdoc}
     *
     * @return View
     */
    public function ok($data = null, array $groups = []): View;

    /**
     * {@inheritdoc}
     *
     * @return View
     */
    public function created($data, array $groups = []): View;

    /**
     * {@inheritdoc}
     *
     * @return View
     */
    public function noContent(): View;

    /**
     * {@inheritdoc}
     *
     * @return View
     */
    public function notModified(): View;

    /**
     * {@inheritdoc}
     *
     * @return View
     */
    public function badRequest($data, array $groups = []): View;
}
