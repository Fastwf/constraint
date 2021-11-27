<?php

namespace Fastwf\Constraint\Constraints\Number;

use Fastwf\Constraint\Api\Constraint;

/**
 * Validation constraint based on minimum value.
 * 
 * This not control the type and can result in an error.
 * When the input data is of unknown type it must be used with {@see Fastwf\Tests\Constraints\Type\IntegerType} or
 * {@see Fastwf\Tests\Constraints\Type\DoubleType}.
 */
class Minimum implements Constraint
{

    /**
     * The minimum value to use to validate the value.
     *
     * @var int|double
     */
    protected $minimum;

    /**
     * true to include the minimum for validation.
     *
     * @var boolean
     */
    protected $exclusive;

    public function __construct($minimum, $exclusive = false)
    {
        $this->minimum = $minimum;
        $this->exclusive = $exclusive;
    }

    /**
     * Allows to get the arithmetic sign corresponding to the evaluation.
     *
     * @return string the arithmetic sign.
     */
    protected function getSign()
    {
        return $this->exclusive ? '>' : '>=';
    }

    public function validate($node, $context)
    {
        $value = $node->get();

        if ($this->exclusive)
        {
            $valid = $value > $this->minimum;
        }
        else
        {
            $valid = $value >= $this->minimum;
        }

        return $valid
            ? null
            : $context->violation($value, 'min', ['minimum' => $this->minimum, 'sign' => $this->getSign()]);
    }

}
