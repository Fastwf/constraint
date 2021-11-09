<?php

namespace Fastwf\Constraint\Constraints\Type;

use Fastwf\Constraint\Api\Constraint;

/**
 * Base constraint validation based on value type.
 */
abstract class Type implements Constraint
{

    protected $type;

    public function __construct($type) {
        $this->type = $type;
    }

    public function validate($node, $context)
    {
        $value = $node->get();

        return \gettype($value) === $this->type
            ? null
            : $context->violation($value, $this->getName(), ['type' => $this->type]);
    }

    /**
     * Get the uniq constraint id associated to type constraint.
     *
     * @return string
     */
    public function getName() {
        return 'type';
    }

}
