<?php

namespace Fastwf\Constraint\Constraints\String;

use Fastwf\Constraint\Constraints\String\Format;

/**
 * Accept any byte sequence.
 * 
 * This not control the type and can result un error.
 * When the input data is of unknown type it must be used with {@see Fastwf\Tests\Constraints\Type\StringType}.
 */
class BinaryFormat extends Format
{

    public function __construct()
    {
        parent::__construct('binary');
    }

    public function validate($node, $context)
    {
        // Data is always valid
        return null;
    }

}
