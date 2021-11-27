<?php

namespace Fastwf\Constraint\Constraints\Logic;

use Fastwf\Constraint\Api\Constraint;

/**
 * Logical constraint that validate a value when exactly one embedded constraint validate the value.
 */
class OneOf implements Constraint
{

    protected $constraints;

    public function __construct(...$constraints)
    {
        $this->constraints = $constraints;
    }

    public function validate($node, $context)
    {
        // Count validation to identify when the value is validated
        $validation = 0;
        foreach ($this->constraints as $constraint) {
            $violation = $constraint->validate($node, $context);

            if ($violation == null)
            {
                ++$validation;

                // Break the loop when 2 constraints validate the value 
                if ($validation == 2)
                {
                    break;
                }
            }
        }

        return $validation == 1 ? null : $context->violation($node->get(), 'oneOf', []);
    }

}
