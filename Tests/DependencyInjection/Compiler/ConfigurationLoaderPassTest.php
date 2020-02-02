<?php

namespace AutoMapperPlus\AutoMapperPlusBundle\Tests\DependencyInjection\Compiler;

use AutoMapperPlus\AutoMapperPlusBundle\DependencyInjection\AutoMapperPlusExtension;
use AutoMapperPlus\AutoMapperPlusBundle\DependencyInjection\Compiler\ConfigurationLoaderPass;
use AutoMapperPlus\AutoMapperPlusBundle\PropertyAccessor\SymfonyPropertyAccessorBridge;
use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractCompilerPassTestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\PropertyAccess\PropertyAccess;

class ConfigurationLoaderPassTest extends AbstractCompilerPassTestCase
{

    /**
     * @var \Symfony\Component\DependencyInjection\Definition
     */
    private $service;

    protected function setUp()
    {
        parent::setUp();
        $extension = new AutoMapperPlusExtension();
        $this->container->registerExtension(new AutoMapperPlusExtension());
        $extension->load([
            'auto_mapper_plus' => [
                'options' => [
                    'property_accessor' => 'custom_property_accessor'
                ]
            ]
        ], $this->container);

        $symfonyPropertyAccessor = $this->registerService('symfony_property_accessor', PropertyAccess::class);
        $this->service = $this->registerService('custom_property_accessor', SymfonyPropertyAccessorBridge::class)
            ->addArgument($symfonyPropertyAccessor);
    }

    public function testCustomPropertyAccessorInConfigurator() {
        $this->compile();
        $this->assertContainerBuilderHasService('automapper_plus.default_options_configurator');
        $configurator = $this->container->getDefinition('automapper_plus.default_options_configurator');
        $options = $configurator->getArgument(0);
        $this->assertArrayHasKey('property_accessor', $options);
        $this->assertEquals($this->service, $options['property_accessor']);
    }

    public function testAutoMapperCustomPropertyAccessor() {
        $this->compile();
        $this->assertTrue($this->container->has(' automapper_plus.mapper'));
    }

    /**
     * @inheritDoc
     */
    protected function registerCompilerPass(ContainerBuilder $container)
    {
        $container->addCompilerPass(new ConfigurationLoaderPass());
    }
}