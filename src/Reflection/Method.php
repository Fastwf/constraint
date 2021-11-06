<?php

namespace Fastwf\Constraint\Reflection;

use Fastwf\Constraint\Data\Node;
use Fastwf\Constraint\Reflection\IMethod;

/**
 * A method implementation that use a ReflectionMethod to access to the property of the object.
 */
class Method implements IMethod
{

    /**
     * The reflection method.
     *
     * @var \ReflectionMethod
     */
    protected $reflection;
    
    public function __construct($reflectionMethod)
    {
        $this->reflection = $reflectionMethod;
    }

    public function invoke($object, ...$args)
    {
        return Node::from(['value' => $this->reflection->invoke($object, ...$args)]);
    }

}
