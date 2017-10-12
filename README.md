# AutoMapperPlusBundle

A Symfony bundle for [AutoMapper+](https://www.github.com/mark-gerarts/automapper-plus).
To see it in action, check out the [demo app](https://github.com/mark-gerarts/automapper-plus-demo-app).

## Table of Contents
* [Installation](#installation)
* [Usage](#usage)
* [Further reading](#further-reading)

## Installation

The bundle is available on packagist:

```bash
$ composer install mark-gerarts/automapper-plus-bundle
```

Don't forget to register the bundle:

```php
$bundles = [
    new AutoMapperPlus\AutoMapperPlusBundle\AutoMapperPlusBundle(),
    // ...
];
```

## Usage

The automapper is available as a service: `automapper_plus.mapper`. You can
register mapping configurations by creating a class that implements the
`AutoMapperConfiguratorInterface`. This configurator class will have to define
a `configure` method, that gets passed the configuration object:

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

Next, you'll have to register this class as a service and tag it with
`automapper_plus.configurator`

```yaml
demo.automapper_configurator:
    class: Demo\AutoMapperConfig
    tags: ['automapper_plus.configurator']

```

You can register all your mappings in a single configurator class, or spread it
across multiple classes. The choice is yours!

## Further reading
For more info regarding the automapper itself, check out the
[project page](https://www.github.com/mark-gerarts/automapper-plus).
