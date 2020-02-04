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

The options for the mapper can be configured. Create a `config/packages/auto_mapper_plus.yaml`
file (or add to your `config.yaml` for older Symfony versions) with the following contents:


```yaml
auto_mapper_plus:
    options:
        create_unregistered_mappings: true
```

These options correspond with the ones of the [Options object](https://github.com/mark-gerarts/automapper-plus#the-options-object).

Full reference:

```yaml
auto_mapper_plus:
    options:
        # Only one option for now, more coming soon!
        create_unregistered_mappings: true
```

Using the configuration is completely optional, you can just set the options directly
on the `Options` object in one of your configurators using `$config->getOptions()`.

## Further reading
For more info regarding the automapper itself, check out the
[project page](https://www.github.com/mark-gerarts/automapper-plus).
