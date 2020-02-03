<?php

namespace AutoMapperPlus\AutoMapperPlusBundle\Tests\DependencyInjection\Compiler;

use AutoMapperPlus\AutoMapper;
use AutoMapperPlus\AutoMapperPlusBundle\DependencyInjection\AutoMapperPlusExtension;
use AutoMapperPlus\AutoMapperPlusBundle\DependencyInjection\Compiler\ConfigurationLoaderPass;
use AutoMapperPlus\AutoMapperPlusBundle\PropertyAccessor\SymfonyPropertyAccessorBridge;
use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractCompilerPassTestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\PropertyAccess\PropertyAccess;

class ConfigurationLoaderPassTest extends AbstractCompilerPassTestCase
{

    /**
     * @var \Symfony\Component\DependencyInjection\Definition
     */
    private $serviceDefinition;

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

        $symfonyPropertyAccessor = $this->registerService('symfony_property_accessor', PropertyAccess::class)
        ->setFactory([PropertyAccess::class, 'createPropertyAccessor']);
        $this->serviceDefinition = $this->registerService('custom_property_accessor', SymfonyPropertyAccessorBridge::class)
            ->setPrivate(false)
            ->addArgument($symfonyPropertyAccessor);
    }

    public function testCustomPropertyAccessorInConfigurator() {
        $this->compile();
        $this->assertContainerBuilderHasService('automapper_plus.default_options_configurator');
        $configurator = $this->container->getDefinition('automapper_plus.default_options_configurator');
        $options = $configurator->getArgument(0);
        $this->assertArrayHasKey('property_accessor', $options);
        $this->assertInstanceOf(Reference::class, $options['property_accessor']);
        $this->assertEquals('custom_property_accessor', (string)$options['property_accessor']);
    }

    public function testAutoMapperCustomPropertyAccessor() {
        $this->compile();
        $this->assertTrue($this->container->has('automapper_plus.mapper'));
        /** @var AutoMapper $mapper */
        $mapper = $this->container->get('automapper_plus.mapper');
        $propertyAccessor = $mapper->getConfiguration()->getOptions()->getPropertyReader();
        $this->assertEquals($this->container->get('custom_property_accessor'), $propertyAccessor);
    }

    /**
     * @inheritDoc
     */
    protected function registerCompilerPass(ContainerBuilder $container)
    {
        $container->addCompilerPass(new ConfigurationLoaderPass());
    }
}