<?php

namespace AutoMapperPlus\AutoMapperPlusBundle\Tests\Helper;

class Person
{
    /**
     * @var string|null
     */
    protected $name;

    /**
     * @var int|null
     */
    protected $age;

    /**
     * @var Address|null
     */
    protected $address;

    /**
     * @var Person[]
     */
    protected $children;

    public function __construct()
    {
        $this->children = [];
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return Person
     */
    public function setName(?string $name): Person
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getAge(): ?int
    {
        return $this->age;
    }

    /**
     * @param int|null $age
     * @return Person
     */
    public function setAge(?int $age): Person
    {
        $this->age = $age;
        return $this;
    }

    /**
     * @return Address|null
     */
    public function getAddress(): ?Address
    {
        return $this->address;
    }

    /**
     * @param Address|null $address
     * @return Person
     */
    public function setAddress(?Address $address): Person
    {
        $this->address = $address;
        return $this;
    }

    /**
     * @return Person[]
     */
    public function getChildren(): ?array
    {
        return $this->children;
    }

    /**
     * @param Person[] $children
     * @return Person
     */
    public function setChildren(array $children): Person
    {
        $this->children = $children;
        return $this;
    }
}