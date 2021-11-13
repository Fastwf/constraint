<?php

namespace Fastwf\Constraint\Constraints\String;

use Fastwf\Constraint\Constraints\String\PcreFormat;

/**
 * Base64 format constraint.
 * 
 * This not control the type and can result un error.
 * When the input data is of unknown type it must be used with {@see Fastwf\Tests\Constraints\Type\StringType}.
 */
class ByteFormat extends PcreFormat
{

    public function __construct()
    {
        parent::__construct('byte', "/^[a-zA-Z0-9+\\/]*={0,3}$/");
    }

}
