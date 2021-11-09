<?php

namespace Fastwf\Constraint\Constraints\String;

use Fastwf\Constraint\Api\Constraint;
use Fastwf\Constraint\Constraints\String\Length;

/**
 * Allows to control the length of the string value to be lower or equals to provided length.
 * 
 * This not control the type and can result un error.
 * When the input data is of unknown type it must be used with {@see Fastwf\Tests\Constraints\Type\StringType}.
 */
class MaxLength extends Length
{

    protected function isValid($length)
    {
        return $length <= $this->length;
    }

    protected function getName()
    {
        return 'maxLength';
    }

}
