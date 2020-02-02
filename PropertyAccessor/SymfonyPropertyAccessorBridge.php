<?php

namespace AutoMapperPlus\AutoMapperPlusBundle\PropertyAccessor;

use AutoMapperPlus\PropertyAccessor\PropertyAccessorInterface;
use Symfony\Component\PropertyAccess as SYM;

class SymfonyPropertyAccessorBridge implements PropertyAccessorInterface
{

    /**
     * @var SYM\PropertyAccessorInterface
     */
    private $propertyAccessor;

    public function __construct(SYM\PropertyAccessorInterface $propertyAccessor)
    {
        $this->propertyAccessor = $propertyAccessor;
    }

    /**
     * @inheritDoc
     */
    public function hasProperty($object, string $propertyName): bool
    {
        return $this->propertyAccessor->isReadable($object, $propertyName)
            || $this->propertyAccessor->isWritable($object, $propertyName);
    }

    /**
     * @inheritDoc
     */
    public function getProperty($object, string $propertyName)
    {
        return $this->propertyAccessor->getValue($object, $propertyName);
    }

    /**
     * @inheritDoc
     */
    public function getPropertyNames($object): array
    {
        $refClass = new \ReflectionClass($object);
        return array_filter(array_map(function(\ReflectionProperty $property) use ($object) {
            if ($this->hasProperty($object, $property->getName())) {
                return $property->getName();
            }
            return false;
        }, $refClass->getProperties()));
    }

    /**
     * @inheritDoc
     */
    public function setProperty($object, string $propertyName, $value): void
    {
        $this->propertyAccessor->setValue($object, $propertyName, $value);
    }
}