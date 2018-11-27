<?php

namespace AutoMapperPlus\AutoMapperPlusBundle;

use AutoMapperPlus\Configuration\AutoMapperConfigInterface;

/**
 * Interface AutoMapperConfiguratorInterface
 *
 * @package AutoMapperPlus\AutoMapperPlusBundle
 */
interface AutoMapperConfiguratorInterface
{
    /**
     * Use this method to register your mappings.
     *
     * @param AutoMapperConfigInterface $config
     */
    public function configure(AutoMapperConfigInterface $config): void;
}
