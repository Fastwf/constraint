<?php

namespace Fastwf\Constraint\Reflection;

use Fastwf\Constraint\Data\Node;
use Fastwf\Constraint\Reflection\Property;
use Fastwf\Constraint\Exceptions\NodeException;

class UndefinedProperty extends Property
{

    public function isReadable() {
        return false;
    }

    public function get($object)
    {
        return new Node();
    }

    public function set($object, $value)
    {
        throw new NodeException("Cannot set a value to undefined property");
    }

}
