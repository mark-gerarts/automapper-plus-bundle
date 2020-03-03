<?php

namespace AutoMapperPlus\AutoMapperPlusBundle\DependencyInjection;

use AutoMapperPlus\AutoMapperPlusBundle\AutoMapperConfiguratorInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

/**
 * Class AutoMapperPlusExtension
 *
 * @package AutoMapperPlus\AutoMapperPlusBundle\DependencyInjection
 */
class AutoMapperPlusExtension extends Extension
{
    private const DEFAULT_OPTIONS_CONFIGURATOR_SERVICE_ID = 'automapper_plus.default_options_configurator';

    /**
     * @inheritdoc
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        // Load our services.
        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__ . '/../Resources/config')
        );
        $loader->load('services.yml');

        $container->registerForAutoconfiguration(AutoMapperConfiguratorInterface::class)
            ->addTag('automapper_plus.configurator');

        // Set up the handling of the configuration. The options defined are
        // passed to a configurator with a very high priority.
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        $this->applyConfiguration($config, $container);
    }

    private function applyConfiguration(array $config, ContainerBuilder $container): void
    {
        if (empty($config['options'])) {
            // No need for the service if there aren't any options.
            $container->removeDefinition(self::DEFAULT_OPTIONS_CONFIGURATOR_SERVICE_ID);
            return;
        }

        $container->setParameter(
            'automapper_plus.default_options',
            $config['options']
        );
    }
}
