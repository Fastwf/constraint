<?php

namespace Fastwf\Constraint\Constraints\String;

use Fastwf\Constraint\Utils\Net;
use Fastwf\Constraint\Constraints\String\Format;

/**
 * hostname format constraint.
 *
 * This not control the type and can result un error.
 * When the input data is of unknown type it must be used with {@see Fastwf\Tests\Constraints\Type\StringType}.
 */
class HostnameFormat extends Format
{

    public function __construct()
    {
        parent::__construct('hostname');
    }

    public function validate($node, $context)
    {
        $value = $node->get();

        return Net::isHostname($value)
            ? null
            : $context->violation($value, $this->getName(), ['format' => $this->format]);
    }

}
