<?php

namespace Fastwf\Constraint\Constraints;

use Fastwf\Constraint\Api\Constraint;

/**
 * Constraint validation that check is a value is defined or not.
 */
class Required implements Constraint
{

    /**
     * A boolean indicating if the value can be null or not.
     *
     * @var boolean
     */
    protected $required;

    /**
     * The constraint to use to validate the value when the value is not null.
     *
     * @var Fastwf\Constraint\Api\Constraint|null $constraint
     */
    protected $constraint;

    /**
     * Constructor
     *
     * @param boolean $required true when the value must be defined.
     * @param Fastwf\Constraint\Api\Constraint|null $constraint the constraint to apply to the value when it's defined
     *                                              (null for no value control).
     */
    public function __construct($required = true, $constraint = null)
    {
        $this->required = $required;
        $this->constraint = $constraint;
    }

    public function validate($node, $context)
    {
        if ($node->isDefined())
        {
            return $this->constraint === null ? null : $this->constraint->validate($node, $context);
        }
        else
        {
            // The value is validated when the value is defined or the value optional (not required)
            return $this->required
                ? $context->violation($node->get(), 'required', [])
                : null;
        }
    }

}
