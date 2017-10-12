<?php

namespace AutoMapperPlus\AutoMapperPlusBundle;

use AutoMapperPlus\AutoMapper;
use AutoMapperPlus\AutoMapperInterface;
use AutoMapperPlus\Configuration\AutoMapperConfigInterface;

/**
 * Class AutoMapperFactory
 *
 * @package AutoMapperPlus\AutoMapperPlusBundle
 */
class AutoMapperFactory
{
    /**
     * @var AutoMapperConfigInterface
     */
    private $config;

    /**
     * AutoMapperFactory constructor.
     *
     * @param AutoMapperConfigInterface $config
     */
    public function __construct(AutoMapperConfigInterface $config)
    {
        $this->config = $config;
    }

    /**
     * @param AutoMapperConfiguratorInterface $configurator
     */
    public function addConfigureCallback(AutoMapperConfiguratorInterface $configurator)
    {
        $configurator->configure($this->config);
    }

    /**
     * @return AutoMapperInterface
     */
    public function create(): AutoMapperInterface
    {
        return new AutoMapper($this->config);
    }
}
