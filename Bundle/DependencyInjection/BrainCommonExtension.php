<?php

namespace Brain\Common\Bundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * {@inheritdoc}
 */
final class BrainCommonExtension extends AbstractBundleExtension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        parent::load($configs, $container);

        $config = $this->processConfiguration(new Configuration(), $configs);

        $this->handleResponseConfiguration($container, $config);
    }

    /**
     * {@inheritdoc}
     */
    protected function getConfigurationFiles(): array
    {
        return [
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

    /**
     * Handle the configuration for "response".
     *
     * @param ContainerBuilder $container
     * @param array $config
     */
    private function handleResponseConfiguration(ContainerBuilder $container, array $config): void
    {
        if ($config['response']['factory']['service'] !== null) {
            $service = $config['response']['factory']['service'];
            $service = str_replace('@', '', $service);

            $factory = $container->getDefinition('brain.common.response.generator');
            $factory->replaceArgument(0, new Reference($service));

            $factory = $container->getDefinition('brain.common.response.helper');
            $factory->replaceArgument(0, new Reference($service));
        }
    }
}
