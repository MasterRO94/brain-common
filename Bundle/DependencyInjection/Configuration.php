<?php

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

        $this->configureResponseNode($root);

        return $builder;
    }

    /**
     * Configure the "response" area.
     *
     * @param ArrayNodeDefinition $root
     */
    private function configureResponseNode(ArrayNodeDefinition $root): void
    {
        $authentication = $root->children()->arrayNode('response');
        $authentication->addDefaultsIfNotSet();

        //  .response.factory

        $factory = $authentication->children()->arrayNode('factory');
        $factory->addDefaultsIfNotSet();

        $factory->children()
            ->scalarNode('service')
                ->defaultNull();
    }
}
