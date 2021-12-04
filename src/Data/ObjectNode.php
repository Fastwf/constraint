<?php

namespace Fastwf\Constraint\Data;

use Fastwf\Constraint\Data\Node;
use Fastwf\Constraint\Reflection\Property;
use Fastwf\Constraint\Reflection\UndefinedProperty;
use Fastwf\Constraint\Utils\Iterators\ObjectNodeIterator;

/**
 * A node that hold any object type and allows to access to it's properties.
 */
class ObjectNode extends Node
{

    protected $reflect = null;
    protected $cache = [];

    private function getProperty($name)
    {
        if (!\array_key_exists($name, $this->cache))
        {
            // Analyse the property
            $this->cache[$name] = $this->reflect !== null
                ? Property::getInstance($this->reflect, $name)
                : new UndefinedProperty();
        }

        return $this->cache[$name];
    }

    public function set($args)
    {
        parent::set($args);

        // When the value is an object, create reflection object to access to it's properties
        if ($this->value !== null)
        {
            $this->reflect = new \ReflectionClass($this->value);
            $this->cache = [];
        }
    }

    public function __get($name)
    {
        return $this->getProperty($name)->get($this->value);
    }

    public function __set($name, $value)
    {
        $this->getProperty($name)->set($this->value, $value);
    }

    public function __isset($name)
    {
        // The main purpose of the Node is to access to hold value in READ mode, so isset must return true when the value is accessible for
        // reading.
        // When value will be set but it's not possible (undefined property or missing setter) a NodeException is thrown.

        return $this->getProperty($name)->isReadable();
    }

    public function getBuiltIn()
    {
        $builtIn = [];
        // Use ObjectNodeIterator to auto convert to built in values
        foreach ($this as $key => $node) {
            $builtIn[$key] = $node->getBuiltIn();
        }

        return $builtIn;
    }

    public function getIterator()
    {
        return $this->reflect === null
            ? new \EmptyIterator()
            : new ObjectNodeIterator($this->value, $this->reflect, $this->cache);
    }

}
