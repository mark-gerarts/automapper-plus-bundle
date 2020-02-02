<?php

namespace AutoMapperPlus\AutoMapperPlusBundle\Tests\Helper;

class AddressDTO
{
    /**
     * @var string|null
     */
    protected $street;

    /**
     * @return string|null
     */
    public function getStreet(): ?string
    {
        return $this->street;
    }

    /**
     * @param string|null $street
     * @return AddressDTO
     */
    public function setStreet(?string $street): AddressDTO
    {
        $this->street = $street;
        return $this;
    }
}