<?php

namespace Fastwf\Constraint\Build\Factory;

use Fastwf\Constraint\Api\Constraint;
use Fastwf\Constraint\Build\Factory\IFactory;
use Fastwf\Constraint\Build\Environment\Environment;

abstract class LogicalFactory implements IFactory
{

    /**
     * The property name in the schema.
     *
     * @var string
     */
    protected $name;

    /**
     * The environment able to load schema.
     *
     * @var Environment
     */
    protected $environment;

    public function __construct($name, $environment)
    {
        $this->name = $name;
        $this->environment = $environment;
    }

    /**
     * Indicate if the schema contains logical definition that this factory is able to create.
     *
     * @param array $schema the schema representing the constraint.
     * @return boolean true when the schema contains logical constraint property.
     */
    public function match($schema)
    {
        return \array_key_exists($this->name, $schema);
    }

    public function create($schema)
    {
        return $this->createConstraint(
            $this->createSubConstraints($schema)
        );
    }

    /**
     * Generate the logical constraint.
     *
     * @param array $subConstraints the constraint that the logical constraint must wrap.
     * @return Constraint the logical constraint.
     */
    public abstract function createConstraint(&$subConstraints);

    /**
     * Generate the constraint that the logical constraint must wrap.
     *
     * @param array $schema the schema representing the constraint.
     * @return array the sub constraint array.
     */
    public abstract function &createSubConstraints($schema);

}
