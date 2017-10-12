<?php

namespace AutoMapperPlus\AutoMapperPlusBundle;

use AutoMapperPlus\Configuration\AutoMapperConfigInterface;

// @todo: figure out a better name..
interface AutoMapperConfiguratorInterface
{
    /**
     * Use this method to register your mappings.
     *
     * @param AutoMapperConfigInterface $config
     */
    public function configure(AutoMapperConfigInterface $config): void;
}
