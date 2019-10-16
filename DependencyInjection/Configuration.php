<?php

namespace AutoMapperPlus\AutoMapperPlusBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('auto_mapper_plus');
        /** @var ArrayNodeDefinition $rootNode */
        $rootNode = \method_exists(TreeBuilder::class, 'getRootNode')
            ? $treeBuilder->getRootNode()
            : $treeBuilder->root('auto_mapper_plus');

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
