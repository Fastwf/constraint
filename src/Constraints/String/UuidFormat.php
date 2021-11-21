<?php

namespace Fastwf\Constraint\Constraints\String;

use Fastwf\Constraint\Constraints\String\PcreFormat;

/**
 * UUID format constraint.
 *
 * This not control the type and can result un error.
 * When the input data is of unknown type it must be used with {@see Fastwf\Tests\Constraints\Type\StringType}.
 */
class UuidFormat extends PcreFormat
{

    public function __construct()
    {
        parent::__construct('uuid', '/^[0-9a-f]{8}(?:-[0-9a-f]{4}){3}-[0-9a-f]{12}$/i');
    }

}
