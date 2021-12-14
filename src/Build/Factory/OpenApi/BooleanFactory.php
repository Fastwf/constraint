<?php

namespace Fastwf\Constraint\Build\Factory\OpenApi;

use Fastwf\Constraint\Constraints\Type\BooleanType;
use Fastwf\Constraint\Build\Factory\OpenApi\AnyFactory;

/**
 * Boolean factory constraint for boolean schema type.
 */
class BooleanFactory extends AnyFactory
{

    protected function createType($schema)
    {
        return new BooleanType();
    }

}
