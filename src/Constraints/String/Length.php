<?php

namespace Fastwf\Constraint\Constraints\String;

use Fastwf\Constraint\Api\Constraint;

/**
 * Allows to control the length of the string value.
 */
abstract class Length implements Constraint
{

    protected $length;

    public function __construct($length)
    {
        $this->length = $length;
    }

    public function validate($node, $context)
    {
        $value = $node->get();

        $actual = \mb_strlen($value);
        return $this->isValid($actual)
            ? null
            : $context->violation($value, $this->getName(), ['length' => $this->length, 'actual' => $actual]);
    }

    /**
     * Validate the length of the value string
     *
     * @param int $length the length of the string
     * @return boolean true when the length is valid
     */
    protected abstract function isValid($length);

    /**
     * Get the uniq constraint name.
     *
     * @return string
     */
    protected abstract function getName();

}
