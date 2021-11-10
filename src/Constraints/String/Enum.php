<?php

namespace Fastwf\Constraint\Constraints\String;

use Fastwf\Constraint\Api\Constraint;

/**
 * Validate a value based on string values enumeration.
 */
class Enum implements Constraint
{

    protected $values;

    /**
     * Constructor.
     *
     * @param array $values the array of expected string values.
     */
    public function __construct($values)
    {
        $this->values = $values;
    }

    /**
     * Format the enum list as human readable string.
     *
     * ```php
     * ['one', 'two'];
     * // result in "'one', 'two'"
     * ```
     * 
     * @return string the enum values representation
     */
    protected function getFormattedEnum()
    {
        return join(
            ', ',
            \array_map(
                function ($value) { return \var_export($value, true); },
                $this->values
            )
        );
    }

    public function validate($node, $context)
    {
        $value = $node->get();

        return \in_array($value, $this->values)
            ? null
            : $context->violation($value, 'enum', ['enum' => $this->getFormattedEnum()]);
    }

}
