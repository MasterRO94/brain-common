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
            'api',
            'component/authentication',
            'component/database',
            'component/date',
            'component/debug',
            'component/form',
            'component/response',
            'component/translation',
            'component/utility',
        ];
    }
}
