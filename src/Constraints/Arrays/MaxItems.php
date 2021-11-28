<?php

namespace Fastwf\Constraint\Constraints\Arrays;

use Fastwf\Constraint\Api\Constraint;
use Fastwf\Constraint\Constraints\Arrays\Count;

/**
 * Allows to control the number of items in array value to be lower or equals to provided length.
 * 
 * This not control the type and can result un error.
 * When the input data is of unknown type it must be used with {@see Fastwf\Tests\Constraints\Type\ArrayType}.
 */
class MaxItems extends Count
{

    protected function isValid($item)
    {
        return $item <= $this->items;
    }

    protected function getName()
    {
        return 'maxItems';
    }

}
