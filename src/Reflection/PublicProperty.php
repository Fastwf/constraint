<?php

namespace Fastwf\Constraint\Reflection;

use Fastwf\Constraint\Data\Node;
use Fastwf\Constraint\Reflection\Property;

class PublicProperty extends Property
{

    protected $property;

    public function __construct($property)
    {
        $this->property = $property;
    }

    public function isReadable()
    {
        return true;
    }

    public function get($object)
    {
        return Node::from(['value' => $this->property->getValue($object)]);
    }

    public function set($object, $value)
    {
        $this->property->setValue($object, $value);
    }

}
