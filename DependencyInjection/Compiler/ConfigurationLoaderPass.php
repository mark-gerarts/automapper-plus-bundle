<?php

namespace AutoMapperPlus\AutoMapperPlusBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class ConfigurationLoaderPass
 *
 * @package AutoMapperPlus\AutoMapperPlusBundle\DependencyInjection\Compiler
 */
class ConfigurationLoaderPass implements CompilerPassInterface
{
    /**
     * @inheritdoc
     */
    public function process(ContainerBuilder $container)
    {
        $mapperFactory = $container->getDefinition('automapper_plus.mapper_factory');
        $configurators = $container->findTaggedServiceIds('automapper_plus.configurator');
        foreach ($configurators as $id => $_) {
            $mapperFactory->addMethodCall('addConfigureCallback', [new Reference($id)]);
        }
    }
}
