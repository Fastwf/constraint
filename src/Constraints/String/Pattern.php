<?php

namespace Fastwf\Constraint\Constraints\String;

use Fastwf\Constraint\Api\Constraint;

/**
 * Allows to control a string value base on regex pattern.
 * 
 * This not control the type and can result un error.
 * When the input data is of unknown type it must be used with {@see Fastwf\Tests\Constraints\Type\StringType}.
 */
class Pattern implements Constraint
{

    protected $pattern;

    /**
     * Constructor
     *
     * @param string $pattern the regex pattern not '/' excluded
     * @param string $flags the regex flags to append
     */
    public function __construct($pattern, $flags='')
    {
        // Escape "/" chars to prevent conflic with expected PCRE pattern
        $pattern = \str_replace("/", "\\/", $pattern);

        $this->pattern = "/${pattern}/${flags}";
    }

    public function validate($node, $context)
    {
        $value = $node->get();

        return \preg_match($this->pattern, $value) === 1
            ? null
            : $context->violation($value, 'pattern', ['pattern' => \var_export($this->pattern, true)]);
    }

}