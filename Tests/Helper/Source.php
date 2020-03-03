<?php

namespace AutoMapperPlus\AutoMapperPlusBundle\Tests\Helper;

class Source
{
    private $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }
}

