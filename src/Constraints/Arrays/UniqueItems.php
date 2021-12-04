<?php

namespace Fastwf\Constraint\Constraints\Arrays;

use Fastwf\Constraint\Api\Constraint;

/**
 * Contraint validator for arrays values. It allows to control the unicity of items.
 * 
 * This not control the type and can result un error.
 * When the input data is of unknown type it must be used with {@see Fastwf\Tests\Constraints\Type\ArrayType}.
 */
class UniqueItems implements Constraint
{

    public function validate($node, $context)
    {
        $items = [];

        $valid = true;
        foreach ($node as $nodeItem)
        {
            // Convert to built-in values to allows to use 'in_array' performances
            //  'in_array' is able to find any boolean, integer, double, string, array or NULL value using '===' operator
            $item = $nodeItem->getBuiltIn();
            if (in_array($item, $items, true))
            {
                $valid = false;
                break;
            }
    
            $items[] = $item;
        }
    
        return $valid ? null : $context->violation($node->get(), 'uniqueItems', []);
    }

}
