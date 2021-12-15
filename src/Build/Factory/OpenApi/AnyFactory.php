<?php

namespace Fastwf\Constraint\Build\Factory\OpenApi;

use Fastwf\Constraint\Api\Constraint;
use Fastwf\Constraint\Constraints\Nullable;
use Fastwf\Constraint\Build\Factory\IFactory;
use Fastwf\Constraint\Build\Environment\IEnvironment;

/**
 * Base factory that create a constraint for no type base.
 */
class AnyFactory implements IFactory
{

    /**
     * The environment constraint loader.
     *
     * @var IEnvironment
     */
    protected $environment;

    public function __construct($environment)
    {
        $this->environment = $environment;
    }

    public function create($schema)
    {
        $constraint = $this->createType($schema);
        return new Nullable(
            \array_key_exists('nullable', $schema) && $schema['nullable'],
            $constraint,
        );
    }

    /**
     * Allows to create the full type constraints from the schema specification.
     * 
     * Nullable constraint must not be set here.
     *
     * @param array $schema the schema specification to use to create the constraint
     * @return Constraint the constraint generated
     */
    protected function createType($schema)
    {
        return null;
    }

}
