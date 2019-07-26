<?php

declare(strict_types=1);

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
    public function load(array $configs, ContainerBuilder $container): void
    {
        parent::load($configs, $container);

        $config = $this->processConfiguration(new Configuration(), $configs);

        $this->handleAuthenticationConfiguration($container, $config);
        $this->handleResponseConfiguration($container, $config);
    }

    /**
     * {@inheritdoc}
     */
    protected function getConfigurationFiles(): array
    {
        return [
            'component/database',
            'component/date',
            'component/debug',
            'component/enum',
            'component/form',
            'component/prototype',
            'component/response',
            'component/serializer',
            'component/system',
            'component/translation',
            'component/utility',
            'component/validator',
        ];
    }

    /**
     * Handle the configuration for "authentication".
     *
     * @param mixed[] $config
     */
    private function handleAuthenticationConfiguration(ContainerBuilder $container, array $config): void
    {
        $service = $config['authentication']['storage']['service'];
        $service = str_replace('@', '', $service);

        $factory = $container->getDefinition('brain.common.database');
        $factory->replaceArgument(2, new Reference($service));
    }

    /**
     * Handle the configuration for "response".
     *
     * @param mixed[] $config
     */
    private function handleResponseConfiguration(ContainerBuilder $container, array $config): void
    {
        if ($config['response']['factory']['service'] === null) {
            return;
        }

        $service = $config['response']['factory']['service'];
        $service = str_replace('@', '', $service);

        $factory = $container->getDefinition('brain.common.response.generator');
        $factory->replaceArgument(0, new Reference($service));

        $factory = $container->getDefinition('brain.common.response.helper');
        $factory->replaceArgument(0, new Reference($service));
    }
}
