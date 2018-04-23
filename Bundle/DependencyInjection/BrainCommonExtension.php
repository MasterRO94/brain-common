<?php

namespace Brain\Common\Bundle\DependencyInjection;

/**
 * {@inheritdoc}
 */
final class BrainCommonExtension extends AbstractBundleExtension
{
    /**
     * {@inheritdoc}
     */
    protected function getConfigurationFiles(): array
    {
        return [
            'components',
        ];
    }
}
