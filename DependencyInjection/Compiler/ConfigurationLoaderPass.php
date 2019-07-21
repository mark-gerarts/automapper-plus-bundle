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

    private const SERVICE_OPTIONS = [
        'source_member_naming_convention'
    ];

    /**
     * @inheritdoc
     */
    public function process(ContainerBuilder $container)
    {
        $this->processConfigurators($container);
        $this->processOptions($container);
    }

    /**
     * Calls all defined configurators.
     *
     * @param ContainerBuilder $container
     */
    private function processConfigurators(ContainerBuilder $container): void
    {
        $mapperFactory = $container->getDefinition('automapper_plus.mapper_factory');
        $configurators = $this->findAndSortTaggedServices('automapper_plus.configurator', $container);
        foreach ($configurators as $configurator) {
            $mapperFactory->addMethodCall('addConfigureCallback', [$configurator]);
        }
    }

    /**
     * Processes the configured options. Replaces service names with their
     * actual definitions.
     *
     * @param ContainerBuilder $container
     */
    private function processOptions(ContainerBuilder $container): void
    {
        $options = $container->getParameter('automapper_plus.default_options');
        foreach (self::SERVICE_OPTIONS as $serviceOption) {
            $serviceName = $options[$serviceOption];
            if (isset($serviceName)) {
                $options[$serviceOption] = $container->getDefinition($serviceName);
            }
        }

        $container
            ->getDefinition('automapper_plus.default_options_configurator')
            ->setArguments([$options]);
    }
}
