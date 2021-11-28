<?php

namespace Fastwf\Constraint\Constraints\Arrays;

use Fastwf\Constraint\Api\Constraint;
use Fastwf\Constraint\Data\Violation;

/**
 * Array constraint that validate items based on an item constraint.
 * 
 * This constraint not control the node type.
 * 
 * Because it validates a node ({@see Fastwf\Constraint\Data\Node}), it is possible to validate any values safely but non array type will be
 * always validated.
 */
class Items implements Constraint
{

    /**
     * The constraint to apply to the array items.
     *
     * @var Fastwf\Constraint\Api\Constraint
     */
    protected $constraint;

    /**
     * Constructor.
     *
     * @param Fastwf\Constraint\Api\Constraint $constraint the constraints on array items
     */
    public function __construct($constraint)
    {
        $this->constraint = $constraint;
    }

    public function validate($node, $context)
    {
        $context = $context->getSubContext($node);

        // The node is an ArrayNode
        $childViolations = [];
        foreach ($node as $index => $nodeItem)
        {
            $itemViolation = $this->constraint->validate($nodeItem, $context);

            if ($itemViolation !== null)
            {
                $childViolations[(string) $index] = $itemViolation;
            }
        }

        // Create the violation when at least one item is invalid
        $violation = null;
        if (!empty($childViolations))
        {
            $violation = $context->violation($node->get(), 'items', []);

            // Add violation using children property
            foreach ($childViolations as $index => $value) {
                $violation->getChildren()[$index] = $value;
            }
        }

        return $violation;
    }

}
