<?php

namespace Fastwf\Constraint\Build\Environment;

use Fastwf\Constraint\Api\Constraint;

/**
 * Pool that contains schema constraint and allows to save information or listen for schema loading events.
 */
class ConstraintPool
{

    /**
     * The cache array of constraint name/constraint pair.
     *
     * @var array
     */
    private $cache = [];

    /**
     * The array that contains callbacks associated to the constraint name.
     *
     * @var array
     */
    private $callbacks = [];

    /**
     * Verify if the pool have any information about the constraint attached to the key.
     *
     * @param string $key the constraint cache key.
     * @return boolean true when the pool contains constraint info.
     */
    public function has($key)
    {
        return \array_key_exists($key, $this->cache);
    }

    /**
     * Get the constraint value associated to the constraint name.
     *
     * @param string $key the constraint cache key.
     * @return Constraint|null the constraint or null is it's not set. 
     */
    public function get($key)
    {
        return $this->cache[$key];
    }

    /**
     * Allows to detect if a constraint is loaded.
     *
     * @param string $key the constraint cache key.
     * @return boolean true when the pool contains constraint info.
     */
    public function isLoaded($key)
    {
        return $this->has($key) && $this->cache[$key] !== null;
    }

    /**
     * Mark the constraint as loading state.
     *
     * @param string $key the constraint cache key.
     * @return void
     */
    public function startLoading($key)
    {
        $this->cache[$key] = null;
    }

    /**
     * Register a constraint assciated to the given key.
     *
     * @param string $key the constraint cache key.
     * @param Constraint $constraint the constraint schema to attach to the key.
     * @return void
     */
    public function setLoaded($key, $constraint)
    {
        $this->cache[$key] = $constraint;

        $callbacks = &$this->getCallbacks($key);
        $length = \count($callbacks);
        while ($length > 0)
        {
            $callback = \array_shift($callbacks);
            \call_user_func($callback, $constraint);

            $length--;
        }
        // Release callback array memory
        unset($this->callbacks[$key]);
    }

    /**
     * Add a callback to loaded event for the given key.
     *
     * @param string $key the constraint cache key.
     * @param mixed $callback the callback to call when #setLoaded is called with $key (the callback can be used only once)
     * @return void
     */
    public function addLoadCallback($key, $callback)
    {
        \array_push($this->getCallbacks($key), $callback);
    }

    /**
     * Get the array that contains callbacks associated to the given constraint name.
     *
     * @param string $key the constraint cache key.
     * @return array the array reference that must contains constraint callbacks
     */
    private function &getCallbacks($key)
    {
        if (!\array_key_exists($key, $this->callbacks))
        {
            $this->callbacks[$key] = [];
        }

        return $this->callbacks[$key];
    }

}
