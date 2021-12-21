<?php

namespace Fastwf\Constraint\Reflection;

use Fastwf\Constraint\Data\Node;

/**
 * Reflexion tool to access to object method.
 */
interface IMethod
{

    /**
     * Invoke the method in the object and return the node containing the value returned.
     *
     * @param mixed $object the object that define the method.
     * @param array $args the method arguments.
     * @return Node the node containing the value.
     */
    public function invoke($object, ...$args);

}
