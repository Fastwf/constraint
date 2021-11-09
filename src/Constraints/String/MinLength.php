<?php

namespace Fastwf\Constraint\Constraints\String;

use Fastwf\Constraint\Api\Constraint;
use Fastwf\Constraint\Constraints\String\Length;

/**
 * Allows to control the length of the string value to be gretter or equals to provided length.
 * 
 * This not control the type and can result un error.
 * When the input data is of unknown type it must be used with {@see Fastwf\Tests\Constraints\Type\StringType}.
 */
class MinLength extends Length
{

    public function __construct($length = 0)
    {
        parent::__construct($length);
    }

    protected function isValid($length)
    {
        return $length >= $this->length;
    }

    protected function getName()
    {
        return 'minLength';
    }

}
