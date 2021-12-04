<?php

namespace Fastwf\Constraint\Data;

use Fastwf\Constraint\Data\ArrayNode;
use Fastwf\Constraint\Data\ObjectNode;

/**
 * Node object that hold values and allows to proxy more complex data.
 */
class Node implements \IteratorAggregate
{

    /**
     * The value hold by the node
     *
     * @var mixed
     */
    protected $value;

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
    public function get()
    {
        return $this->value;
    }

    /**
     * Retun the value with possible transformations to have basic php value type (boolean, integer, double, string, array, NULL).
     * 
     * array type can be a list or object with key/value pair.
     * 
     * @return mixed
     */
    public function getBuiltIn()
    {
        // For Node and ArrayNode class, the value hold is a boolean, integer, double, string, array or NULL value.
        //  For object type, it's required to convert them to an array of key/value pair
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
        // Ignore
    }

    /**
     * Check if the property exists.
     *
     * @param string $name property name
     * @return boolean true when is set
     */
    public function __isset($name)
    {
        return false;
    }

    /**
     * Get an iterator to iterate on value key/pair
     *
     * @return \Traversable
     */
    public function getIterator()
    {
        // By default a simple value have not items or key/value pairs
        return new \EmptyIterator();
    }

    /**
     * Node factory from given arguments.
     *
     * @param array $args the node arguments ({@see Node::set($args)} for details)
     * @return Fastwf\Constraint\Data\Node the node instanciated
     */
    public static function from($args=[])
    {
        if (\array_key_exists("value", $args))
        {
            switch (\gettype($args["value"])) {
                case 'array':
                    $node = new ArrayNode($args);
                    break;
                case 'object':
                    $node = new ObjectNode($args);
                    break;
                default:
                    $node = new Node($args);
                    break;
            }
        }
        else
        {
            $node = new Node();
        }

        return $node;
    }

}
