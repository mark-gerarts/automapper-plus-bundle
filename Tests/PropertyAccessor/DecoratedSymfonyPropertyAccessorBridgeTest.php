<?php

namespace AutoMapperPlus\AutoMapperPlusBundle\Tests\PropertyAccessor;

use AutoMapperPlus\AutoMapperPlusBundle\PropertyAccessor\DecoratedSymfonyPropertyAccessorBridge;
use AutoMapperPlus\AutoMapperPlusBundle\Tests\Helper\Destination;
use AutoMapperPlus\AutoMapperPlusBundle\Tests\Helper\Source;
use AutoMapperPlus\PropertyAccessor\PropertyAccessorInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;

class DecoratedSymfonyPropertyAccessorBridgeTest extends PropertyAccessorTestBase
{
    protected function getPropertyAccessor(): PropertyAccessorInterface
    {
        $propertyAccessor = PropertyAccess::createPropertyAccessor();

        return new DecoratedSymfonyPropertyAccessorBridge($propertyAccessor);
    }

    public function testItMapsPrivateValues()
    {
        $source = new Source('a private value');

        $destination = $this->mapper->map($source, Destination::class);

        $this->assertEquals('a private value', $destination->getName());
    }
}
