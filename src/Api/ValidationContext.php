<?php

namespace Fastwf\Constraint\Api;

use Fastwf\Constraint\Data\Violation;
use Fastwf\Constraint\Data\ViolationConstraint;

/**
 * A context that help to perform constraint validation.
 */
class ValidationContext
{

    /**
     * The root node currently evaluated.
     *
     * @var Fastwf\Constraint\Data\Node
     */
    private $root;

    /**
     * The parent node of the current value node evaluated (is null when the root node is evaluated).
     *
     * @var Fastwf\Constraint\Data\Node|null
     */
    private $parent;

    public function __constraint($root, $parent)
    {
        $this->root = $root;
        $this->parent = $parent;
    }

    /**
     * Getter for root node.
     *
     * @return Fastwf\Constraint\Data\Node the root node
     */
    public function getRoot()
    {
        return $this->root;
    }

    /**
     * Getter for parent node.
     *
     * @return Fastwf\Constraint\Data\Node|null the parent node
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Generate or update a violation object.
     *
     * @param mixed $value the value currently evaluated.
     * @param string $code the uniq code corresponding to the current constraint
     * @param array $parameters the constraint fail information as key/value pair
     * @param Fastwf\Constraint\Data\Violation|null $violation the violation object to update or null to create a new violation object
     * @return Fastwf\Constraint\Data\Violation the violation object created or updated
     */
    public function violation($value, $code, $parameters, $violation=null)
    {
        if ($violation === null)
        {
            $violation = new Violation($value);
        }

        \array_push($violation->getViolations(), new ViolationConstraint($code, $parameters));

        return $violation;
    }

    /**
     * Generate a sub context for the given parent.
     *
     * @param Fastwf\Constraint\Data\Node $parent
     * @return Fastwf\Constraint\Api\ValidationContext the sub context.
     */
    public function getSubContext($parent)
    {
        return new ValidationContext($this->root, $parent);
    }

}
