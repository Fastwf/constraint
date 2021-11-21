<?php

namespace Fastwf\Constraint\Constraints\String;

use Fastwf\Constraint\Utils\Net;
use Fastwf\Constraint\Constraints\String\Format;

/**
 * Email format constraint.
 *
 * This not control the type and can result un error.
 * When the input data is of unknown type it must be used with {@see Fastwf\Tests\Constraints\Type\StringType}.
 */
class EmailFormat extends Format
{

    private const LOCAL_PART = "/^([-!#$%&'*+\\/=?^_`{}|~0-9A-Z]+(\.[-!#$%&'*+\\/=?^_`{}|~0-9A-Z]+)*"
        ."|\"([ \001-\010\013\014\016-\037!#-\\[\\]-\177]|\\\\[ \001-\011\013\014\016-\177])*\")$/i";

    private const IP_PART = "/^\\[(.*)\\]$/";

    public function __construct()
    {
        parent::__construct('email');
    }

    public function validate($node, $context)
    {
        $value = $node->get();

        // 1 - Extract the 2 segments arround '@'
        $matches = [];
        $valid = \preg_match('/^(.*)@([^@]+)$/', $value, $matches) === 1;

        if ($valid)
        {
            $local = $matches[1];
            $domain = $matches[2];

            // 2 - Basic email format is respected:
            //  * local part: 64 octets max
            //  * domain part: 63 octets max
            //  * local part match the self::LOCAL_PART pattern
            $valid = \strlen($local) <= 64
                && \strlen($domain) <= 63
                && \preg_match(self::LOCAL_PART, $matches[1]) === 1;
            if ($valid)
            {
                $ipMatches = [];

                // 3 - Check the domain part:
                //  * Is a hostname
                //  * or is an IP v4 value
                //  * or is an IP v6 value
                $valid = Net::isHostname($domain)
                    || (
                        \preg_match(self::IP_PART, $domain, $ipMatches) === 1 
                        && (Net::isIPv4($ipMatches[1]) || Net::isIPv6($ipMatches[1]))
                    );
            }
        }

        return $valid
            ? null
            : $context->violation($value, $this->getName(), ['format' => $this->format]);
    }

}
