<?php

declare(strict_types=1);

namespace Brain\Common\Bundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

use ReflectionObject;

/**
 * Abstract extension.
 */
abstract class AbstractBundleExtension extends Extension
{
    /**
     * Return all the configuration files to load.
     *
     * This is the configuration file name relative to the "Resources/config/services" directory.
     * The extension assumed will be of YAML format ".yaml".
     *
     * @return string[]
     */
    abstract protected function getConfigurationFiles(): array;

    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $this->handleConfigurationFiles($container);
    }

    /**
     * Handle the loading of bundle configuration service files.
     */
    final protected function handleConfigurationFiles(ContainerBuilder $container): void
    {
        $class = new ReflectionObject($this);
        $directory = realpath(sprintf('%s/../Resources/config/services', dirname($class->getFileName())));
        $loader = new YamlFileLoader($container, new FileLocator($directory));

        // Load each of the configurations mentioned in the extension.
        foreach ($this->getConfigurationFiles() as $file) {
            $loader->load(sprintf('%s.yaml', $file));
        }
    }
}
