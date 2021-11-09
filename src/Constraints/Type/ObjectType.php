<?php

namespace Fastwf\Constraint\Constraints\Type;

use Fastwf\Constraint\Api\Constraint;
use Fastwf\Constraint\Constraints\Type\Type;

/**
 * Type constraint validation for object (array of key/pair or class instance).
 */
class ObjectType extends Type
{

    public function __construct() {}

    public function validate($node, $context)
    {
        $value = $node->get();

        $isObject = false;

        switch (\gettype($value)) {
            case 'object':
                $isObject = true;
                break;
            case 'array':
                // Check if there is a string key
                $isObject = true;
                foreach (\array_keys($value) as $key) {
                    if (\gettype($key) !== 'string') {
                        $isObject = false;
                        break;
                    }
                }
                break;
            default:
                break;
        }

        return $isObject ? null : $context->violation($value, $this->getName(), ['type' => 'object']);
    }

}
