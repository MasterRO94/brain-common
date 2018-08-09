<?php

declare(strict_types=1);

namespace Brain\Common\Bundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * {@inheritdoc}
 */
final class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $builder = new TreeBuilder();

        $root = $builder->root('brain_common');

        $this->configureAuthenticationNode($root);
        $this->configureResponseNode($root);

        return $builder;
    }

    /**
     * Configure the "authentication" area.
     */
    private function configureAuthenticationNode(ArrayNodeDefinition $root): void
    {
        $authentication = $root->children()->arrayNode('authentication');
        $authentication->addDefaultsIfNotSet();

        // .authentication.storage
        $storage = $authentication->children()->arrayNode('storage');
        $storage->addDefaultsIfNotSet();

        $storage->children()
            ->scalarNode('service');
    }

    /**
     * Configure the "response" area.
     */
    private function configureResponseNode(ArrayNodeDefinition $root): void
    {
        $authentication = $root->children()->arrayNode('response');
        $authentication->addDefaultsIfNotSet();

        // .response.factory
        $factory = $authentication->children()->arrayNode('factory');
        $factory->addDefaultsIfNotSet();

        $factory->children()
            ->scalarNode('service')
            ->defaultNull();
    }
}
