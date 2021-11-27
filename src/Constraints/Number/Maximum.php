<?php

namespace Fastwf\Constraint\Constraints\Number;

use Fastwf\Constraint\Api\Constraint;

/**
 * Validation constraint based on maximum value.
 * 
 * This not control the type and can result in an error.
 * When the input data is of unknown type it must be used with {@see Fastwf\Tests\Constraints\Type\IntegerType} or
 * {@see Fastwf\Tests\Constraints\Type\DoubleType}.
 */
class Maximum implements Constraint
{

    /**
     * The maximum value to use to validate the value.
     *
     * @var int|double
     */
    protected $maximum;

    /**
     * true to include the maximum for validation.
     *
     * @var boolean
     */
    protected $exclusive;

    public function __construct($maximum, $exclusive = false)
    {
        $this->maximum = $maximum;
        $this->exclusive = $exclusive;
    }

    public function validate($node, $context)
    {
        $value = $node->get();

        if ($this->exclusive)
        {
            $valid = $this->maximum > $value;
        }
        else
        {
            $valid = $this->maximum >= $value;
        }

        return $valid
            ? null
            : $context->violation($value, 'max', ['maximum' => $this->maximum, 'sign' => ($this->exclusive ? '>' : '>=')]);
    }

}
