<?php

namespace AutoMapperPlus\AutoMapperPlusBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('auto_mapper_plus');

        $rootNode
            ->children()
                ->arrayNode('options')
                    ->children()
                        ->booleanNode('create_unregistered_mappings')->end()
                    ->end()
                ->end() // options
            ->end();

        return $treeBuilder;
    }
}
