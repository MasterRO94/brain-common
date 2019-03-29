<?php

declare(strict_types=1);

namespace Brain\Common\Tests\Fixture\Database;

use Doctrine\Common\Persistence\Proxy;

/**
 * Entity representation with nothing.
 *
 * @internal Test fixture only.
 */
final class BasicEntityProxyTestFixture extends BasicEntityTestFixture implements
    Proxy
{
    /**
     * {@inheritdoc}
     */
    public function __load()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function __isInitialized()
    {
    }
}
