<?php

namespace Fastwf\Constraint\Data;

use Fastwf\Constraint\Data\Node;
use Fastwf\Constraint\Utils\Iterators\ArrayNodeIterator;

/**
 * A node that hold array values as key/value pair or "list" array.
 */
class ArrayNode extends Node
{

    public function __get($name)
    {
        return \array_key_exists($name, $this->value)
            ? Node::from(["value" => &$this->value[$name]])
            : new Node();
    }

    public function __set($name, $value)
    {
        $this->value[$name] = $value;
    }

    public function __isset($name)
    {
        return \array_key_exists($name, $this->value);
    }

    public function getBuiltIn()
    {
        $builtIn = [];
        // Use ArrayNodeIterator to auto convert to built in values
        foreach ($this as $key => $node) {
            $builtIn[$key] = $node->getBuiltIn();
        }

        return $builtIn;
    }

    public function getIterator(): \Traversable
    {
        return new ArrayNodeIterator($this->value);
    }

}
