<?php

namespace Fastwf\Constraint\Utils\Iterators;

use Fastwf\Constraint\Data\Node;
use Fastwf\Constraint\Reflection\Property;

/**
 * Iterator that allows to access to all object properties.
 */
class ObjectNodeIterator implements \Iterator
{

    /**
     * The original object to iterate.
     *
     * @var object
     */
    private $value;

    /**
     * The property cache.
     *
     * @var array
     */
    private $cache;

    /**
     * The reflection class object
     *
     * @var \ReflectionClass
     */
    private $reflect;

    /**
     * The internal array iterator.
     *
     * @var \ArrayIterator
     */
    private $iter;

    /**
     * The internal key of the current item.
     *
     * @var string
     */
    private $key;

    /**
     * The internal node corresponding to the current item.
     *
     * @var Node
     */
    private $current;

    /**
     * Constructor.
     *
     * @param object $value the object to use to iterate on it's properties.
     * @param \ReflectionClass $reflect the reflection class object of the object (non null).
     * @param array $cache the cache object where properties object must be saved.
     */
    public function __construct($value, $reflect, &$cache) {
        $this->value = $value;
        $this->reflect = $reflect;
        $this->cache = &$cache;

        // Generate the property names array
        $reflect = $this->reflect;
        $properties = [];

        // Add current class properties
        $clsProperties = $this->reflect
            ->getProperties(\ReflectionProperty::IS_PRIVATE | \ReflectionProperty::IS_PROTECTED | \ReflectionProperty::IS_PUBLIC);
        self::pushPropertyNames($properties, $clsProperties);

        // Add all super class private property names
        while ($reflect !== false)
        {
            $cls = $reflect->getParentClass();
        
            if ($cls === false)
            {
                $reflect = false;
            }
            else
            {
                // Load super private properties
                $reflect = new \ReflectionClass($cls->name);
                $clsProperties = $reflect->getProperties(\ReflectionProperty::IS_PRIVATE);

                self::pushPropertyNames($properties, $clsProperties);
            }
        }

        $this->iter = new \ArrayIterator($properties);
    }

    public function current()
    {
        return $this->current->get($this->value);
    }

    public function key()
    {
        return $this->key;
    }

    public function next(): void
    {
        $this->iter->next();
        $this->nextReadableProperty();
    }

    public function rewind(): void
    {
        $this->iter->rewind();

        $this->nextReadableProperty();
    }

    public function valid(): bool
    {
        return $this->iter->valid();
    }

    private function nextReadableProperty()
    {
        // Iterate while the next value is notReadable
        $notReadable = true;
        while ($notReadable)
        {
            if ($this->iter->valid())
            {
                $this->current = $this->currentPropertyNode();
                $notReadable = !$this->current->isReadable();

                if ($notReadable) {
                    $this->iter->next();
                }
            }
            else
            {
                $notReadable = false;
            }
        }
    }

    /**
     * Use the internal iterator to access to the current property name.
     *
     * @return Property the property object that allows to access to the property.
     */
    private function currentPropertyNode()
    {
        $name = $this->iter->current();
        $this->key = $name;

        if (!\array_key_exists($name, $this->cache))
        {
            // Cache the property object in ObjectNode cache
            $this->cache[$name] = Property::getInstance($this->reflect, $name);
        }

        return $this->cache[$name];
    }

    /**
     * Inject all property names not already present in the array.
     *
     * @param array $array the array where properties will be pushed.
     * @param array $properties the list of properties to add to the $array.
     * @return void
     */
    private static function pushPropertyNames(&$array, &$properties)
    {
        foreach ($properties as $property) {
            $name = $property->name;
            if (!\in_array($name, $array))
            {
                \array_push($array, $name);
            }
        }
    }

}
