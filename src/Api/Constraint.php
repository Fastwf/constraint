<?php

namespace Fastwf\Constraint\Api;

use Fastwf\Constraint\Data\Node;
use Fastwf\Constraint\Data\Violation;
use Fastwf\Constraint\Api\ValidationContext;

/**
 * Constraint interface that allows to define a basic validation behaviour.
 */
interface Constraint  
{
    
    /**
     * Validate the value provided using object validation logic.
     *
     * @param Node $value the node value to validate.
     * @param ValidationContext the validation context containing root, parent node and violation factory method.
     * @return Violation|null null when the object is null or a Violation instance containing validation fail informations.
     */
    public function validate($node, $context);

}
