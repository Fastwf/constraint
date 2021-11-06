<?php

namespace Fastwf\Constraint\Reflection;

use Fastwf\Constraint\Data\Node;
use Fastwf\Constraint\Reflection\Method;
use Fastwf\Constraint\Reflection\Property;
use Fastwf\Constraint\Reflection\UndefinedGetterMethod;
use Fastwf\Constraint\Reflection\UndefinedSetterMethod;

class StdProperty extends Property
{
    
    private $name;
    private $reflection;

    private $getter = null;
    private $setter = null;

    public function __construct($reflection, $property)
    {
        $this->reflection = $reflection;

        // Access to the property name and upper the first letter (when alpha)
        $this->name = $property->getName();
    }

    /**
     * Search the getter method when it's required and return the getter method.
     *
     * @return Fastwf\Constraint\Reflection\IMethod a getter method
     */
    private function getter()
    {
        if ($this->getter === null)
        {
            $name = $this->name;
            
            // 1 - Search for public method with the same name as the property
            // 2 - Search for convention getter method name
            $suffix = \strtoupper($name[0]) . \substr($name, 1, \strlen($name) - 1);
            foreach ([$name, "get$suffix", "is$suffix", "has$suffix"] as $methodName) {
                if ($this->reflection->hasMethod($methodName))
                {
                    $method = $this->reflection->getMethod($methodName);
                    
                    if ($method->isPublic())
                    {
                        $this->getter = new Method($method);
                        break;
                    }
                }
            }

            // 3 - It's impossible to access to the property using method, so return an empty Node
            if ($this->getter === null)
            {
                $this->getter = new UndefinedGetterMethod();
            }
        }

        return $this->getter;
    }

    public function isReadable()
    {
        return !($this->getter() instanceof UndefinedGetterMethod);
    }

    public function get($object)
    {
        return $this->getter()->invoke($object);
    }

    public function set($object, $value)
    {
        if ($this->setter === null)
        {
            $name = $this->name;
            // 1 - Verify that the setter exists and it's an accessible method
            $methodName = "set" . \strtoupper($name[0]) . \substr($name, 1, \strlen($name) - 1);

            if ($this->reflection->hasMethod($methodName))
            {
                $method = $this->reflection->getMethod($methodName);
                
                if ($method->isPublic())
                {
                    $this->setter = new Method($method);
                }
            }

            // 2 - If the setter is not found use UndefinedSetterMethod
            if ($this->setter === null)
            {
                $this->setter = new UndefinedSetterMethod();
            }
        }

        $this->setter->invoke($object, $value);
    }

}