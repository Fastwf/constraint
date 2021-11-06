<?php

namespace Fastwf\Constraint\Reflection;

use Fastwf\Constraint\Data\Node;
use Fastwf\Constraint\Reflection\IMethod;

/**
 * A method implementation that use an undefined getter method that allows to return empty Node.
 */
class UndefinedGetterMethod implements IMethod
{

    public function invoke($object, ...$args)
    {
        return new Node();
    }

}
