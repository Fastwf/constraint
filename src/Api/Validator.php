<?php

namespace Fastwf\Constraint\Api;

use Fastwf\Constraint\Data\Node;
use Fastwf\Constraint\Api\ValidationContext;

/**
 * Validator object to use to validate values using a constraint definition.
 */
class Validator
{

    /**
     * The root constraint to use to validate a value.
     *
     * @var Fastwf\Constraint\Api\Constraint
     */
    protected $constraint;

    /**
     * The root violation node corresponding to the last validated value.
     *
     * @var Fastwf\Constraint\Data\Violation
     */
    protected $violation;

    /**
     * A boolean that indicate if the violation property contains interpolated messages or not.
     *
     * @var boolean
     */
    protected $isMessageInterpolated;

    public function __construct($constraint)
    {
        $this->constraint = $constraint;
    }

    /**
     * Perform validation operation using the constraint hold on the value.
     *
     * @param mixed $value the value to validate
     * @return boolean true when the value respect the constraints
     */
    public function validate($value)
    {
        $node = Node::from(['value' => $value]);

        // Validate the object using the constraint hold
        $this->violation = $this->constraint->validate($node, new ValidationContext($node, null));
        $this->isMessageInterpolated = false;

        // When the violation is null, the value is valid
        return $this->violation === null;
    }

    /**
     * Allows to obtain the validation object containing informations about constraint violated.
     *
     * @return Fastwf\Constraint\Data\Violation|null the validation or null when the value is validated or validate is not called
     */
    public function getViolations()
    {
        if ($this->violation !== null && !$this->isMessageInterpolated)
        {
            // TODO: Inject error message interpolated before returning the violation object
            $this->isMessageInterpolated = true;
        }

        return $this->violation;
    }

}
