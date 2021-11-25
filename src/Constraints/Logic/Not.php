<?php

namespace Fastwf\Constraint\Constraints\Logic;

use Fastwf\Constraint\Api\Constraint;

/**
 * Logical contraint that validate the value when it's not respecting the embedded constraint.
 */
class Not implements Constraint
{

    /**
     * The constraint that must be used for not validation.
     *
     * @var Fastwf\Constraint\Api\Constraint
     */
    protected $constraint;

    public function __construct($constraint)
    {
        $this->constraint = $constraint;
    }

    public function validate($node, $context)
    {
        $violation = $this->constraint->validate($node, $context);

        return $violation == null
            ? $context->violation($node->get(), 'not', [])
            : null;
    }

}