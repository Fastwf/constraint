<?php

namespace Fastwf\Constraint\Build\Environment;

use Fastwf\Constraint\Api\Constraint;
use Fastwf\Constraint\Build\Loader\ILoader;
use Fastwf\Constraint\Build\Factory\IFactory;
use Fastwf\Constraint\Exceptions\LoadException;
use Fastwf\Constraint\Build\Environment\Environment;
use Fastwf\Constraint\Build\Factory\OpenApi\AnyFactory;
use Fastwf\Constraint\Build\Factory\OpenApi\ArrayFactory;
use Fastwf\Constraint\Build\Factory\OpenApi\NumberFactory;
use Fastwf\Constraint\Build\Factory\OpenApi\ObjectFactory;
use Fastwf\Constraint\Build\Factory\OpenApi\StringFactory;
use Fastwf\Constraint\Build\Environment\OpenApiEnvironment;
use Fastwf\Constraint\Build\Factory\OpenApi\BooleanFactory;
use Fastwf\Constraint\Build\Factory\OpenApi\IntegerFactory;
use Fastwf\Constraint\Build\Factory\OpenApi\Logical\NotFactory;
use Fastwf\Constraint\Build\Factory\OpenApi\Logical\AllOfFactory;
use Fastwf\Constraint\Build\Factory\OpenApi\Logical\AnyOfFactory;
use Fastwf\Constraint\Build\Factory\OpenApi\Logical\OneOfFactory;

/**
 * The open api environment able to create constraint from open api schema definition.
 */
class OpenApiEnvironment extends Environment
{

    /**
     * The list of type factories.
     *
     * @var array
     */
    private $factories = [];

    /**
     * The logical factory list.
     *
     * @var array
     */
    private $logicalFactories;

    public function __construct($loader)
    {
        parent::__construct($loader);

        $this->logicalFactories = [
            new NotFactory($this),
            new AllOfFactory($this),
            new AnyOfFactory($this),
            new OneOfFactory($this),
        ];
    }

    /**
     * Analyse the schema constraint using logical schema definition.
     *
     * @param array $schema the schema representing the constraint.
     * @param Constraint $constraint the reference where constraint loaded will be stored.
     * @return boolean true when logical definition is found
     */
    private function setLogicalConstraint($schema, &$constraint)
    {
        foreach ($this->logicalFactories as $factory) {
            // When the logical factory detect its definition key word in the schema, create the constraint and stop iteration.
            if ($factory->match($schema))
            {
                $constraint = $factory->create($schema);
                return true;
            }
        }

        return false;
    }

    public function loadSchema($schema, &$constraint)
    {
        // The '$ref' have priority on 'type'
        //  'type' have the priority on logical constraints
        //  when no open api key word is provided in schema, a simple nullable constraint is generated 
        if (\array_key_exists('$ref', $schema))
        {
            $this->load($schema['$ref'], $constraint);
        }
        else if (\array_key_exists('type', $schema))
        {
            // Use the type factory to create the constraint
            $constraint = $this->factories[$schema['type']]
                ->create($schema);
        }
        else if (!$this->setLogicalConstraint($schema, $constraint))
        {
            // Create a constraint that accept any value
            $constraint = (new AnyFactory($this))->create($schema);
        }
    }

    /**
     * Register a constraint factory for given type.
     *
     * @param string $type the constraint type name.
     * @param IFactory $factory the instance of the factory.
     * @return void
     */
    public function registerTypeFactory($type, $factory)
    {
        $this->factories[$type] = $factory;
    }

    /**
     * Get the registered constraint factory associated to the given type.
     *
     * @param string $type the constraint type name.
     * @return IFactory the instance of the factory.
     */
    public function getTypeFactory($type)
    {
        if (array_key_exists($type, $this->factories))
        {
            return $this->factories[$type];
        }
        else
        {
            throw new LoadException("'$type' type factory not found");
        }
    }

    /**
     * Generate a default open api environment with default type factory.
     *
     * @param ILoader $loader the schema loader.
     * @return OpenApiEnvironment the environment instance.
     */
    public static function getDefault($loader)
    {
        $env = new OpenApiEnvironment($loader);

        $env->registerTypeFactory('string', StringFactory::getDefault($env));
        $env->registerTypeFactory('number', new NumberFactory($env));
        $env->registerTypeFactory('integer', new IntegerFactory($env));
        $env->registerTypeFactory('boolean', new BooleanFactory($env));
        $env->registerTypeFactory('array', new ArrayFactory($env));
        $env->registerTypeFactory('object', new ObjectFactory($env));

        return $env;
    }

}
