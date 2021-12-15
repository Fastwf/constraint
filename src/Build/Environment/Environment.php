<?php

namespace Fastwf\Constraint\Build\Environment;

use Fastwf\Constraint\Api\Constraint;
use Fastwf\Constraint\Build\Loader\ILoader;
use Fastwf\Constraint\Exceptions\LoadException;
use Fastwf\Constraint\Build\Environment\ConstraintPool;

/**
 * Environment constraint loader.
 * 
 * The environment is able to create constraints from schema definition.
 */
abstract class Environment
{

    /**
     * The source schema loader.
     *
     * @var ILoader
     */
    protected $loader;

    /**
     * The pool where loaded constraint must be stored.
     *
     * @var ConstraintPool
     */
    protected $pool;

    public function __construct($loader)
    {
        $this->loader = $loader;
        $this->pool = new ConstraintPool();
    }

    /**
     * Return an array containing the source name and it's namespace.
     *
     * @param string $source the source name
     * @return array an array like ['namespace', 'sourceName']
     */
    private function getSource($source)
    {
        $groups = [];
        if (\preg_match('/^(?:([^@]+)@)?(.+)$/', $source, $groups) !== 1)
        {
            throw new LoadException("The source name '$source' is invalid");
        }

        return [$groups[1], $groups[2]];
    }

    /**
     * Get the current schema loader.
     *
     * @return ILoader the loader.
     */
    public function getLoader()
    {
        return $this->loader;
    }

    /**
     * Set the schema loader.
     *
     * @param ILoader $loader the new loader.
     * @return void
     */
    public function setLoader($loader)
    {
        $this->loader = $loader;
    }
    
    /**
     * Load a schema from source.
     *
     * @param string $source the source name.
     * @param Constraint $constraint the reference where constraint loaded will be stored.
     * @return void
     */
    public function load($source, &$constraint)
    {
        if ($this->pool->has($source))
        {
            if ($this->pool->isLoaded($source))
            {
                $constraint = $this->pool->get($source);
            }
            else
            {
                $this->pool->addLoadCallback($source, function ($freshConstraint) use (&$constraint) {
                    // Set the constraint using its reference
                    $constraint = $freshConstraint;
                });
            }
        }
        else
        {
            $this->pool->startLoading($source);
            // Load the schema from the source and build the constraint
            $name = $this->getSource($source);
            $this->loadSchema(
                $this->loader->load($name[1], $name[0]),
                $constraint,
            );
            $this->pool->setLoaded($source, $constraint);
        }
    }

    /**
     * Create a constraint from a schema.
     *
     * @param array $schema the schema representing the constraint.
     * @param Constraint $constraint the reference where constraint loaded will be stored.
     * @return void
     */
    public abstract function loadSchema($schema, &$constraint);

}
