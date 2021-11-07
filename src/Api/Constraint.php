<?php

namespace Fastwf\Constraint\Api;

/**
 * Constraint interface that allows to define a basic validation behaviour.
 */
interface Constraint  
{
    
    /**
     * Validate the value provided using object validation logic.
     *
     * @param Fastwf\Constraint\Data\Node $value the node value to validate.
     * @param Fastwf\Constraint\ValidationContext the validation context containing root, parent node and violation factory method.
     * @return Fastwf\Constraint\Data\Violation|null null when the object is null or a Violation instance containing validation fail
     *                                               informations.
     */
    public function validate($node, $context);

}
