<?php

namespace AutoMapperPlus\AutoMapperPlusBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\HttpKernel\Kernel;

class Configuration implements ConfigurationInterface
{
    private const ROOT_NODE_ID = 'auto_mapper_plus';

    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder(self::ROOT_NODE_ID);
        /** @var ArrayNodeDefinition $rootNode */
        $rootNode = \method_exists(TreeBuilder::class, 'getRootNode')
            ? $treeBuilder->getRootNode()
            : $treeBuilder->root(self::ROOT_NODE_ID);

        $rootNode
            ->children()
                ->arrayNode('options')
                    ->children()
                        ->booleanNode('create_unregistered_mappings')->end()
                        ->booleanNode('skip_constructor')->end()
                        ->booleanNode('use_substitution')->end()
                        ->booleanNode('ignore_null_properties')->end()
                        ->scalarNode('source_member_naming_convention')->end()
                        ->scalarNode('property_accessor')->end()
                    ->end()
                ->end() // options
            ->end();

        return $treeBuilder;
    }
}
