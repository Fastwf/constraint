<?php

namespace Fastwf\Constraint\Constraints\String;

use Fastwf\Constraint\Constraints\String\PcreFormat;

/**
 * Base64 URL format constraint.
 * 
 * This not control the type and can result un error.
 * When the input data is of unknown type it must be used with {@see Fastwf\Tests\Constraints\Type\StringType}.
 */
class Base64UrlFormat extends PcreFormat
{

    public function __construct()
    {
        parent::__construct('base64url', "/^[a-zA-Z0-9_-]*={0,3}$/");
    }

}
