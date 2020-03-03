# AutoMapperPlusBundle

A Symfony bundle for [AutoMapper+](https://www.github.com/mark-gerarts/automapper-plus).
To see it in action, check out the [demo app](https://github.com/mark-gerarts/automapper-plus-demo-app).

## Table of Contents
* [Installation](#installation)
* [Usage](#usage)
* [Configuration](#configuration)
* [Further reading](#further-reading)

## Installation

The bundle is available on packagist:

```bash
$ composer require mark-gerarts/automapper-plus-bundle
```

Don't forget to register the bundle:

```php
$bundles = [
    new AutoMapperPlus\AutoMapperPlusBundle\AutoMapperPlusBundle(),
    // ...
];
```

## Usage

The automapper is available as a service: `automapper_plus.mapper` (or just type hint
the `AutoMapperPlus\AutoMapperInterface`).

You can register mapping configurations by creating a class that implements the
`AutoMapperConfiguratorInterface`. This configurator class will have to define a
`configure` method, that gets passed the configuration object:

```php
<?php

namespace Demo;

use AutoMapperPlus\AutoMapperPlusBundle\AutoMapperConfiguratorInterface;
use AutoMapperPlus\Configuration\AutoMapperConfigInterface;
use Demo\Model\Employee\Employee;
use Demo\Model\Employee\EmployeeDto;

class AutoMapperConfig implements AutoMapperConfiguratorInterface
{
    public function configure(AutoMapperConfigInterface $config): void
    {
        $config->registerMapping(Employee::class, EmployeeDto::class)
            ->forMember('fullName', function (Employee $source) {
                return $source->getFirstName() . ' ' . $source->getLastName();
            });

        // And so on..
    }
}
```

If you use autowiring, the configurators will be picked up automatically.
Alternatively, you'll have to register the class as a service and tag it
with `automapper_plus.configurator`. You can optionally add a priority parameter
to the tag.


```yaml
demo.automapper_configurator:
    class: Demo\AutoMapperConfig
    tags: ['automapper_plus.configurator']

```

You can register all your mappings in a single configurator class, or spread it
across multiple classes. The choice is yours!

## Configuration

The options for the mapper can be configured. Create a `config/packages/automapper_plus.yaml`
file (or add to your `config.yaml` for older Symfony versions) with the following contents:


```yaml
auto_mapper_plus:
    options:
        create_unregistered_mappings: true
```

These options correspond with the ones of the [Options object](https://github.com/mark-gerarts/automapper-plus#the-options-object).

Full reference (Not all options are supported at the moment, more coming soon!):

```yaml
auto_mapper_plus:
    options:
        # These options are example values, and not necessarily the default
        # ones. If an option is not provided, the base library's default will
        # be used.
        create_unregistered_mappings: true
        skip_constructor: true
        use_substitution: true
        ignore_null_properties: false
        # Note that this should be the service name, and not necessarily the
        # FQCN.
        property_accessor: AutoMapperPlus\AutoMapperPlusBundle\PropertyAccessor\SymfonyPropertyAccessorBridge
```

Using the configuration is completely optional, you can just set the options directly
on the `Options` object in one of your configurators using `$config->getOptions()`.

## Symfony property accessors

The bundle contains a bridge for the [Symfony PropertyAccessor](https://symfony.com/components/PropertyAccess).
It provides 2 variants:

- The `SymfonyPropertyAccessorBridge` is basically only the functionality of
  Symfony's component, meaning you can NOT set private properties directly
  (which is a good thing if you want to be more strict).
- The `DecoratedPropertyAccessor` uses the Symfony property access, but falls
  back to the default in case of failure. This means private properties will
  be handled, even if they don't have a getter/setter.

Both options provide allow to use `fromProperty` with full property paths,
e.g. `forMember('aProperty', Operation::fromProperty('some.nested[child]'));`.
Note that other usages of property paths have not been tested and are not
guaranteed to work. It will be investigated in the 2.x release
([related issue](https://github.com/mark-gerarts/automapper-plus/issues/51)).

Sample service definition:

```yaml
services:
    AutoMapperPlus\AutoMapperPlusBundle\PropertyAccessor\SymfonyPropertyAccessorBridge:
        arguments:
            $propertyAccessor: '@property_accessor'
```

In your `automapper_plus.yaml` configuration:

```yaml
auto_mapper_plus:
    options:
        property_accessor: 'AutoMapperPlus\AutoMapperPlusBundle\PropertyAccessor\SymfonyPropertyAccessorBridge'
```

## Further reading
For more info regarding the automapper itself, check out the
[project page](https://www.github.com/mark-gerarts/automapper-plus).
