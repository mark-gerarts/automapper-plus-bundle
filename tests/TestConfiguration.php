<?php
declare(strict_types=1);

namespace AutoMapperPlus\AutoMapperPlusBundle\test;


use AutoMapperPlus\AutoMapperPlusBundle\DependencyInjection\Configuration;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

class TestConfiguration extends TestCase
{

    public function testGetConfiguration() {

        $configuration = new Configuration();

        $this->assertInstanceOf(TreeBuilder::class, $configuration->getConfigTreeBuilder());

    }

}
