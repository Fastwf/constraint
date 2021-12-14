<?php

namespace Fastwf\Constraint\Build\Factory\OpenApi\Logical;

use Fastwf\Constraint\Constraints\Logic\Not;
use Fastwf\Constraint\Build\Factory\LogicalFactory;

/**
 * The base logical array factory.
 * 
 * The sub constraint factory system is the same for 'allOf', 'anyOf' or 'oneOf' constraint.
 */
abstract class LAFactory extends LogicalFactory
{

    public function &createSubConstraints($schema)
    {
        $subConstraints = [];

        foreach ($schema[$this->name] as $subSchema) {
            // Add the sub constraint by reference to the sub constraint array
            $length = \array_push($subConstraints, null);
            $this->environment->loadSchema($subSchema, $subConstraints[$length - 1]);
        }

        return $subConstraints;
    }

}
