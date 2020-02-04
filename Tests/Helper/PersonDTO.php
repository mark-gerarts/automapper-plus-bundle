<?php

namespace AutoMapperPlus\AutoMapperPlusBundle\Tests\Helper;

class PersonDTO
{
    /**
     * @var string|null
     */
    protected $name;

    /**
     * @var AddressDTO|null
     */
    protected $adr;

    /**
     * @var PersonDTO[]
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
     * @return PersonDTO
     */
    public function setName(?string $name): PersonDTO
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return AddressDTO|null
     */
    public function getAdr(): ?AddressDTO
    {
        return $this->adr;
    }

    /**
     * @param AddressDTO|null $adr
     * @return PersonDTO
     */
    public function setAdr(?AddressDTO $adr): PersonDTO
    {
        $this->adr = $adr;
        return $this;
    }

    /**
     * @return PersonDTO[]
     */
    public function getChildren(): ?array
    {
        return $this->children;
    }

    /**
     * @param PersonDTO[] $children
     * @return PersonDTO
     */
    public function setChildren(array $children): PersonDTO
    {
        $this->children = $children;
        return $this;
    }
}