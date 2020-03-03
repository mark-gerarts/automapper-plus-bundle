<?php

namespace AutoMapperPlus\AutoMapperPlusBundle\PropertyAccessor;

use AutoMapperPlus\PropertyAccessor\PropertyAccessor;
use Symfony\Component\PropertyAccess\Exception\AccessException;
use Symfony\Component\PropertyAccess\Exception\InvalidArgumentException;
use Symfony\Component\PropertyAccess\Exception\NoSuchPropertyException;
use Symfony\Component\PropertyAccess\Exception\UnexpectedTypeException;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface as SymfonyPropertyAccessorInterface;

class DecoratedPropertyAccessor extends PropertyAccessor
{
    /**
     * @var SymfonyPropertyAccessorInterface
     */
    private $propertyAccessor;

    public function __construct(SymfonyPropertyAccessorInterface $propertyAccessor)
    {
        $this->propertyAccessor = $propertyAccessor;
    }

    public function hasProperty($object, string $propertyName): bool
    {
        if ($this->propertyAccessor->isReadable($object, $propertyName)) {
            return true;
        }

        return parent::hasProperty($object, $propertyName);
    }

    public function getProperty($object, string $propertyName)
    {
        try {
            return $this->propertyAccessor->getValue($object, $propertyName);
        }
        catch (NoSuchPropertyException $e) {
            return parent::getProperty($object, $propertyName);
        }
    }

    public function setProperty($object, string $propertyName, $value): void
    {
        try {
            $this->propertyAccessor->setValue($object, $propertyName, $value);
        }
        catch (AccessException | UnexpectedTypeException | InvalidArgumentException $e) {
            parent::setProperty($object, $propertyName, $value);
        }
    }
}
