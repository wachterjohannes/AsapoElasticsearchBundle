<?php

namespace Asapo\Bundle\ElasticsearchBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();

        $treeBuilder->root('asapo_elasticsearh')
            ->children()
                ->arrayNode('metadata')
                    ->children()
                        ->arrayNode('folders')->prototype('scalar')->end()->end()
                        ->arrayNode('mapping')
                            ->useAttributeAsKey('className')
                            ->prototype('array')
                                ->addDefaultsIfNotSet()
                                ->children()
                                    ->scalarNode('type')->defaultValue(null)->end()
                                    ->arrayNode('properties')
                                        ->prototype('array')
                                            ->addDefaultsIfNotSet()
                                            ->children()
                                                ->scalarNode('type')->defaultValue(null)->end()
                                                ->scalarNode('analyzer')->defaultValue(null)->end()
                                            ->end()
                                        ->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
