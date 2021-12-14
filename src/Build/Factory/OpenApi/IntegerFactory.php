<?php

namespace Fastwf\Constraint\Build\Factory\OpenApi;

use Fastwf\Constraint\Constraints\Type\IntegerType;
use Fastwf\Constraint\Build\Factory\OpenApi\NumberFactory;

/**
 * Allows to create constraint to validate integer type.
 */
class IntegerFactory extends NumberFactory
{

    protected function getTypeConstraint()
    {
        return new IntegerType();
    }

}
