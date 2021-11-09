<?php

namespace Fastwf\Constraint\Constraints\Type;

use Fastwf\Constraint\Api\Constraint;
use Fastwf\Constraint\Constraints\Type\Type;

/**
 * Type constraint validation for double.
 */
class DoubleType extends Type
{

    public function __construct() {}

    public function validate($node, $context)
    {
        $value = $node->get();

        // Integers and doubles are accepted
        return \in_array(\gettype($value), ['integer', 'double'])
            ? null
            : $context->violation($value, $this->getName(), ['type' => 'double']);
    }

}
