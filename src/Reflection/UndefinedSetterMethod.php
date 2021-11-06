<?php

namespace Fastwf\Constraint\Reflection;

use Fastwf\Constraint\Data\Node;
use Fastwf\Constraint\Reflection\IMethod;
use Fastwf\Constraint\Exceptions\NodeException;

/**
 * A method implementation that use an undefined setter method which does nothing.
 */
class UndefinedSetterMethod implements IMethod
{

    public function invoke($object, ...$args)
    {
        throw new NodeException("Cannot set a value without setter");
    }

}
