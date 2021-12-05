<?php

namespace Fastwf\Constraint\Constraints\String;

use Fastwf\Constraint\Constraints\String\Blank;

/**
 * Constraint validation for not blank values.
 * 
 * Warning: null values is not evaluated, use {@see Fastwf\Constraint\Constraints\Nullable} for this purpose.
 * 
 * This not control the type and can result un error (this is the case for null values).
 * When the input data is of unknown type it must be used with {@see Fastwf\Tests\Constraints\Type\StringType}.
 */
class NotBlank extends Blank
{

    public function validate($node, $context)
    {
        $value = $node->get();

        return !$this->isBlank($value)
            ? null
            : $context->violation($value, 'not-blank', []);
    }

}
