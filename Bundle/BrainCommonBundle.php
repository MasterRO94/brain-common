<?php

namespace Brain\Common\Bundle;

use Brain\Common\Bundle\DependencyInjection\AbstractBundleExtension;
use Brain\Common\Bundle\DependencyInjection\BrainCommonExtension;

use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * {@inheritdoc}
 */
final class BrainCommonBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function getContainerExtension(): AbstractBundleExtension
    {
        return new BrainCommonExtension();
    }
}
