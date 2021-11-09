<?php

namespace Fastwf\Constraint\Constraints\Type;

use Fastwf\Constraint\Api\Constraint;
use Fastwf\Constraint\Constraints\Type\Type;

/**
 * Type constraint validation for double.
 */
class DoubleType extends Type
{

    public function __construct() {
        // validate method is overriden by this calss.
        //  So is not necessary to call the parent constructor that setup the parent::validate
    }

    public function validate($node, $context)
    {
        $value = $node->get();

        // Integers and doubles are accepted
        return \in_array(\gettype($value), ['integer', 'double'])
            ? null
            : $context->violation($value, $this->getName(), ['type' => 'double']);
    }

}
