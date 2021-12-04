<?php

namespace Fastwf\Tests\Model;

use Fastwf\Tests\Model\Super;

class SuperParent extends Super
{
    
    private $superParent;

    public function setSuperParent($superParent)
    {
        $this->superParent = $superParent;
    }

    public function getSuperParent()
    {
        return $this->superParent;
    }

}