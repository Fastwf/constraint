<?php

namespace Fastwf\Constraint\Constraints\Number;

use Fastwf\Constraint\Api\Constraint;

/**
 * Constraint that verify that the value is multiple of diviser.
 * 
 * This not control the type and can result in an error.
 * When the input data is of unknown type it must be used with {@see Fastwf\Tests\Constraints\Type\IntegerType} or
 * {@see Fastwf\Tests\Constraints\Type\DoubleType}.
 */
class MultipleOf implements Constraint
{
    
    /**
     * The diviser value.
     *
     * @var double|integer
     */
    protected $diviser;

    public function __construct($diviser)
    {
        $this->diviser = $diviser;
    }

    public function validate($node, $context)
    {
        $value = $node->get();

        $quotient = $value / $this->diviser;

        // Modulus cannot be used for double divider
        return ((int) $quotient) == $quotient
            ? null
            : $context->violation($value, 'multipleOf', ['diviser' => $this->diviser]);
    }

}
