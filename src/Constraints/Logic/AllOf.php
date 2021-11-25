<?php

namespace Fastwf\Constraint\Constraints\Logic;

use Fastwf\Constraint\Api\Constraint;

/**
 * Logical constraint that validate a value when all embedded constraint validate the value.
 */
class AllOf implements Constraint
{

    protected $constraints;

    public function __construct(...$constraints)
    {
        $this->constraints = $constraints;
    }

    public function validate($node, $context)
    {
        // Invalidate at the first constraint that invalidate the value
        $valid = true;
        foreach ($this->constraints as $constraint) {
            $violation = $constraint->validate($node, $context);

            if ($violation != null)
            {
                $valid = false;
                break;
            }
        }

        return $valid ? null : $context->violation($node->get(), 'allOf', []);
    }

}
