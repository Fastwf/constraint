<?php

namespace Fastwf\Constraint\Constraints;

use Fastwf\Constraint\Api\Constraint;

/**
 * Constraint validation that allows null value or apply embedded validations when is not.
 */
class Nullable implements Constraint
{

    /**
     * A boolean indicating if the value can be null or not.
     *
     * @var boolean
     */
    protected $nullable;

    /**
     * The constraint to use to validate the value when the value is not null.
     *
     * @var Fastwf\Constraint\Api\Constraint $constraint
     */
    protected $constraint;

    /**
     * Constructor
     *
     * @param boolean $nullable
     * @param Fastwf\Constraint\Api\Constraint $constraint
     */
    public function __construct($nullable, $constraint)
    {
        $this->nullable = $nullable;
        $this->constraint = $constraint;
    }

    public function validate($node, $context)
    {
        $value = $node->get();

        if ($value === null)
        {
            $violation = $this->nullable ? null : $context->violation($value, 'not-null', []);
        }
        else
        {
            $violation = $this->constraint->validate($node, $context);
        }

        return $violation;
    }

}
