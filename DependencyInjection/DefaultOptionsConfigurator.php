<?php

namespace AutoMapperPlus\AutoMapperPlusBundle\DependencyInjection;

use AutoMapperPlus\AutoMapperPlusBundle\AutoMapperConfiguratorInterface;
use AutoMapperPlus\Configuration\AutoMapperConfigInterface;
use AutoMapperPlus\Configuration\Options;

class DefaultOptionsConfigurator implements AutoMapperConfiguratorInterface
{
    /**
     * @var array
     */
    private $defaultOptions;

    public function __construct(array $defaultOptions)
    {
        $this->defaultOptions = $defaultOptions;
    }

    public function configure(AutoMapperConfigInterface $config): void
    {
        $options = $config->getOptions();

        foreach ($this->defaultOptions as $name => $value) {
            $this->applyOption($options, $name, $value);
        }
    }

    private function applyOption(Options $options, string $name, $value): void
    {
        switch ($name) {
            case 'create_unregistered_mappings':
                $value
                    ? $options->createUnregisteredMappings()
                    : $options->dontCreateUnregisteredMappings();
                break;
            case 'skip_constructor':
                $value
                    ? $options->skipConstructor()
                    : $options->dontSkipConstructor();
                break;
            case 'use_substitution':
                $value
                    ? $options->allowSubstitution()
                    : $options->disallowSubstitution();
                break;
            case 'ignore_null_properties':
                $value
                    ? $options->ignoreNullProperties()
                    : $options->dontIgnoreNullProperties();
                break;
            case 'property_accessor':
                $options->setPropertyAccessor($value);
                break;
        }
    }
}
