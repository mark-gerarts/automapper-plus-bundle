<?php

namespace AutoMapperPlus\AutoMapperPlusBundle\DependencyInjection\Compiler;

use AutoMapperPlus\PropertyAccessor\PropertyAccessorInterface;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;
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
        'source_member_naming_convention',
        'property_accessor',
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
        if ($mapperFactory) {
            $configurators = $this->findAndSortTaggedServices('automapper_plus.configurator', $container);
            foreach ($configurators as $configurator) {
                $mapperFactory->addMethodCall('addConfigureCallback', [$configurator]);
            }
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
        if ($container->hasParameter('automapper_plus.default_options')) {
            $options = $container->getParameter('automapper_plus.default_options');
            foreach (self::SERVICE_OPTIONS as $serviceOption) {
                if (isset($options[$serviceOption])) {
                    $serviceName = $options[$serviceOption];
                    if (isset($serviceName) && $container->hasDefinition($serviceName)) {
                        $options[$serviceOption] = new Reference($serviceName);
                    }
                }
            }

            $container
                ->getDefinition('automapper_plus.default_options_configurator')
                ->setArguments([$options]);
        }
    }
}
