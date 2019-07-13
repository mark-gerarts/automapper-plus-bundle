<?php

namespace AutoMapperPlus\AutoMapperPlusBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Compiler\PriorityTaggedServiceTrait;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class ConfigurationLoaderPass
 *
 * @package AutoMapperPlus\AutoMapperPlusBundle\DependencyInjection\Compiler
 */
class ConfigurationLoaderPass implements CompilerPassInterface
{
    use PriorityTaggedServiceTrait;

    /**
     * @inheritdoc
     */
    public function process(ContainerBuilder $container)
    {
        $mapperFactory = $container->getDefinition('automapper_plus.mapper_factory');
        $configurators = $this->findAndSortTaggedServices('automapper_plus.configurator', $container);
        foreach ($configurators as $configurator) {
            $mapperFactory->addMethodCall('addConfigureCallback', [$configurator]);
        }
    }
}
