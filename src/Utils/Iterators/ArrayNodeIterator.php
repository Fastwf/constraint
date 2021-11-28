<?php

namespace Fastwf\Constraint\Utils\Iterators;

use Fastwf\Constraint\Data\Node;

/**
 * Iterator implementation that allows to iterate on php array values.
 * 
 * This class can be used to iterate over array as list or array of key/value pair.
 */
class ArrayNodeIterator implements \Iterator
{

    /**
     * The internal array iterator.
     *
     * @var \ArrayIterator
     */
    private $iter;

    public function __construct($array)
    {
        // \ArrayIterator cannot be extended, so wrap to benefit from C performances  
        $this->iter = new \ArrayIterator($array);
    }

    public function current()
    {
        return Node::from(['value' => $this->iter->current()]);
    }

    public function key()
    {
        return $this->iter->key();
    }

    public function next()
    {
        $this->iter->next();
    }

    public function rewind()
    {
        $this->iter->rewind();
    }

    public function valid()
    {
        return $this->iter->valid();
    }

}
