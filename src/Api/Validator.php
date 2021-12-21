<?php

namespace Fastwf\Constraint\Api;

use Fastwf\Constraint\Data\Node;
use Fastwf\Constraint\Api\Constraint;
use Fastwf\Constraint\Data\Violation;
use Fastwf\Constraint\Api\ValidationContext;
use Fastwf\Constraint\Api\ViolationIterator;
use Fastwf\Constraint\Api\SimpleTemplateProvider;

/**
 * Validator object to use to validate values using a constraint definition.
 */
class Validator
{

    /**
     * The root constraint to use to validate a value.
     *
     * @var Constraint
     */
    protected $constraint;

    /**
     * The root violation node corresponding to the last validated value.
     *
     * @var Violation
     */
    protected $violation;

    /**
     * The violation iterator for injecting error message from error code.
     *
     * @var ViolationIterator
     */
    protected $iterator;

    /**
     * A boolean that indicate if the violation property contains interpolated messages or not.
     *
     * @var boolean
     */
    protected $isMessageInterpolated;

    public function __construct($constraint, $provider = null)
    {
        $this->constraint = $constraint;
        $this->iterator = new ViolationIterator($provider === null ? new SimpleTemplateProvider() : $provider);
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
     * @return Violation|null the validation or null when the value is validated or validate is not called
     */
    public function getViolations()
    {
        if ($this->violation !== null && !$this->isMessageInterpolated)
        {
            // Inject error message interpolated before returning the violation object
            $this->iterator->iterate($this->violation);
            $this->isMessageInterpolated = true;
        }

        return $this->violation;
    }

}
