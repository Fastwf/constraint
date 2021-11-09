<?php

namespace Fastwf\Constraint\Constraints\Type;

use Fastwf\Constraint\Api\Constraint;
use Fastwf\Constraint\Constraints\Type\Type;

/**
 * Type constraint validation for boolean.
 */
class BooleanType extends Type
{

    public function __construct() {
        parent::__construct("boolean");
    }

}
