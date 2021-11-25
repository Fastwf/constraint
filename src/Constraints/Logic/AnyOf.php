<?php

namespace Fastwf\Constraint\Constraints\Logic;

use Fastwf\Constraint\Api\Constraint;

/**
 * Logical constraint that validate a value when at least one embedded constraint validate the value.
 */
class AnyOf implements Constraint
{

    protected $constraints;

    public function __construct(...$constraints)
    {
        $this->constraints = $constraints;
    }

    public function validate($node, $context)
    {
        // Validate at the first constraint that invalidate the value
        $valid = false;
        foreach ($this->constraints as $constraint) {
            $violation = $constraint->validate($node, $context);

            if ($violation == null)
            {
                $valid = true;
                break;
            }
        }

        return $valid ? null : $context->violation($node->get(), 'anyOf', []);
    }

}
