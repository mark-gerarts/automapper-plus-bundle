<?php

namespace AutoMapperPlus\AutoMapperPlusBundle;

use AutoMapperPlus\AutoMapperPlusBundle\DependencyInjection\Compiler\ConfigurationLoaderPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class AutoMapperPlusBundle
 *
 * @package AutoMapperPlus\AutoMapperPlusBundle
 */
class AutoMapperPlusBundle extends Bundle
{
    /**
     * @inheritdoc
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new ConfigurationLoaderPass());
    }
}
