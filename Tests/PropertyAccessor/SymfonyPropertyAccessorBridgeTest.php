<?php

namespace AutoMapperPlus\AutoMapperPlusBundle\Tests\PropertyAccessor;

use AutoMapperPlus\AutoMapperPlusBundle\PropertyAccessor\SymfonyPropertyAccessorBridge;
use AutoMapperPlus\PropertyAccessor\PropertyAccessorInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;

class SymfonyPropertyAccessorBridgeTest extends PropertyAccessorTestBase
{
    protected function getPropertyAccessor(): PropertyAccessorInterface
    {
        $propertyAccessor = PropertyAccess::createPropertyAccessor();

        return new SymfonyPropertyAccessorBridge($propertyAccessor);
    }

}
