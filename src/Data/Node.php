<?php

namespace Fastwf\Constraint\Data;

/**
 * Node object that hold values and allows to proxy more complex data.
 */
class Node 
{

    /**
     * The value hold by the node
     *
     * @var mixed
     */
    private $value;

    /**
     * Indicate if the value hold is defined or not.
     *
     * @var boolean
     */
    private $defined;

    /**
     * Node constructor.
     * 
     * @param array $args the node arguments ({@see Node::set($args)} for details)
     */
    public function __construct($args=[]) {
        $this->set($args);
    }

    /**
     * Get the value hold by the node
     *
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Indicate if the value hold is defined or not.
     *
     * @return boolean
     */
    public function isDefined()
    {
        return $this->defined;
    }

    /**
     * Set the node values.
     * 
     * Expect an array with 2 named arguments:
     * - "value" key that holds the value.
     * - "isDefined" true to specify that null value is "undefined" (ignored when the value is not null or value is not provided).
     *
     * ```php
     * ["value" => 10]; // hold 10
     * ["value" => 10, "isDefined" => false]; // hold 10 and the value is considered defined
     * ["value" => null]; // hold null and the value is considered defined
     * ["value" => null, "isDefined" => false];
     * [] // in both cases, the node hold null and is considered undefined
     * ```
     * 
     * @param array $args the node arguments
     */
    public function set($args)
    {
        $isSet = \array_key_exists("value", $args);

        // Set the value with given value or to null otherwise
        $this->value = $isSet ? $args["value"] : null;

        // Set the value defined
        if ($this->value === null)
        {
            $this->defined = \array_key_exists("isDefined", $args) ? $args["isDefined"] : $isSet;
        }
        else
        {
            $this->defined = true;
        }
    }

    /**
     * Return a node that hold the value associated to the given name.
     *
     * @param string $name the name of the key to query
     * @return Fastwf\Constraint\Data\Node a node corresponding to the key
     */
    public function __get($name)
    {
        // cannot hold sub values -> return empty node
        return new Node();
    }

    /**
     * Set the value for the given property name.
     *
     * @param string $name property name
     * @param mixed $value value to save
     */
    public function __set($name, $value)
    {
        // Ignore for simple node -> cannot hold sub values
    }

}
