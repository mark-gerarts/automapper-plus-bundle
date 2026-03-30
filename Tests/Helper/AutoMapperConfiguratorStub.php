<?php

namespace AutoMapperPlus\AutoMapperPlusBundle\Tests\Helper;

use AutoMapperPlus\AutoMapperPlusBundle\AutoMapperConfiguratorInterface;
use AutoMapperPlus\Configuration\AutoMapperConfigInterface;

class AutoMapperConfiguratorStub implements AutoMapperConfiguratorInterface
{
    public function configure(AutoMapperConfigInterface $config): void
    {
    }
}
