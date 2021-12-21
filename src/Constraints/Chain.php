<?php

namespace Fastwf\Constraint\Constraints;

use Fastwf\Constraint\Data\Node;
use Fastwf\Constraint\Api\Constraint;
use Fastwf\Constraint\Data\Violation;
use Fastwf\Constraint\Api\ValidationContext;

/**
 * Specific constraint validation that chain constraints and allows to pass all constraint or stop on first violation.
 */
class Chain implements Constraint
{

    /**
     * A boolean that indicate if it's required to stop on the first error or not.
     *
     * @var boolean
     */
    protected $stop;

    /**
     * The constraints to chain for value validation.
     *
     * @var array
     */
    protected $constraints;

    /**
     * Constructor.
     *
     * @param boolean $stopOnFirst true when the constraint must stop the validation on first violation.
     * @param array ...$constraints the list of constraints to chain
     */
    public function __construct($stopOnFirst, ...$constraints)
    {
        $this->stop = $stopOnFirst;
        $this->constraints = $constraints;
    }

    /**
     * Merge violations on the first violation item of the violations array.
     *
     * @param array $violations a non empty array of violation object (no length check)
     * @return Violation
     */
    private function mergeViolations($violations)
    {
        $violation = \current($violations);
        $finalViolations = &$violation->getViolations();

        while (($v = \next($violations)) !== false)
        {
            \array_push($finalViolations, ...$v->getViolations());
        }
        \reset($violations);

        return $violation;
    }

    /**
     * Use constraints to validate the node value and return all violation constraints or null when value is valid.
     *
     * @param Node $node the node value to validate
     * @param ValidationContext $context the validation context
     * @return Violation|null the violation or null
     */
    protected function validateAll($node, $context)
    {
        $violations = [];
        foreach ($this->constraints as $constraint) {
            $violation = $constraint->validate($node, $context);

            if ($violation != null)
            {
                \array_push($violations, $violation);
            }
        }

        return empty($violations)
            ? null
            : $this->mergeViolations($violations);
    }

    /**
     * Use constraints to validate the node value and return the first violation constraint or null when value is valid.
     *
     * @param Node $node the node value to validate
     * @param ValidationContext $context the validation context
     * @return Violation|null the violation or null
     */
    protected function validateUntilViolation($node, $context)
    {
        // Invalidate at the first constraint that invalidate the value
        $violation = null;
        foreach ($this->constraints as $constraint) {
            $violation = $constraint->validate($node, $context);

            if ($violation != null)
            {
                break;
            }
        }

        return $violation;
    }

    public function validate($node, $context)
    {
        return $this->stop
            ? $this->validateUntilViolation($node, $context)
            : $this->validateAll($node, $context);
    }

}
