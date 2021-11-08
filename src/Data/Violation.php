<?php

namespace Fastwf\Constraint\Data;

/**
 * A data object that contains validation constraints information for a value.
 */
class Violation
{

    /**
     * The value associated to this violation constraint.
     *
     * @var mixed
     */
    private $value;

    /**
     * The list of violations.
     *
     * @var array
     */
    private $violations;

    /**
     * The array of children violations.
     *
     * @var array|null
     */
    private $children;

    public function __construct($value, $violations = [], $children = [])
    {
        $this->value = $value;
        $this->violations = $violations;
        $this->children = $children;
    }

    /**
     * Getter for $value that correspond this violation.
     *
     * @return void
     */
    public function &getValue()
    {
        return $this->value;
    }

    /**
     * Access to the violations array (by reference).
     *
     * @return array
     */
    public function &getViolations()
    {
        return $this->violations;
    }

    /**
     * Access to the children array (by reference).
     *
     * @return array
     */
    public function &getChildren()
    {
        return $this->children;
    }

    /**
     * Indicate if there are children violations vor the current value.
     *
     * @return boolean true when children violations exists
     */
    public function hasChildren()
    {
        return \count($this->children) > 0;
    }

}
