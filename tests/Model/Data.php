<?php

namespace Fastwf\Tests\Model;

use Fastwf\Tests\Model\SuperParent;

class Data extends SuperParent
{

    public $name;

    private $parent;

    private $root;

    private $isAlive;

    private $children;

    private $internal;

    public function __construct($internal = true)
    {
        $this->internal = $internal;
    }

    public function getParent()
    {
        return $this->parent;
    }

    public function setParent($parent)
    {
        $this->parent = $parent;
    }

    public function isRoot()
    {
        return $this->root;
    }

    public function setRoot($root)
    {
        $this->root = $root;
    }

    public function isAlive()
    {
        return $this->isAlive;
    }

    public function setAlive($isAlive)
    {
        $this->isAlive = $isAlive;
    }

    public function setChildren($children)
    {
        $this->children = $children;
    }

    public function hasChildren()
    {
        return $this->children;
    }

}
