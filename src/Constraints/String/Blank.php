<?php

namespace Fastwf\Constraint\Constraints\String;

use Fastwf\Constraint\Api\Constraint;

/**
 * Constraint validation for blank values.
 * 
 * Warning: null is not considered as blank, use {@see Fastwf\Constraint\Constraints\Nullable} for this purpose.
 * 
 * This not control the type and can result un error (this is the case for null values).
 * When the input data is of unknown type it must be used with {@see Fastwf\Tests\Constraints\Type\StringType}.
 */
class Blank implements Constraint
{

    public function validate($node, $context)
    {
        $value = $node->get();

        return $this->isBlank($value)
            ? null
            : $context->violation($value, 'blank', []);
    }

    protected function isBlank($sequence)
    {
        return \ctype_space($sequence);
    }

}
