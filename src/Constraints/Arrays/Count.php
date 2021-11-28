<?php

namespace Fastwf\Constraint\Constraints\Arrays;

use Fastwf\Constraint\Api\Constraint;

/**
 * Allows to control the number of items in array value.
 */
abstract class Count implements Constraint
{

    /**
     * The limit of items.
     *
     * @var int
     */
    protected $items;

    public function __construct($items)
    {
        $this->items = $items;
    }

    public function validate($node, $context)
    {
        $value = $node->get();

        $actual = count($value);
        return $this->isValid($actual)
            ? null
            : $context->violation($value, $this->getName(), ['items' => $this->items, 'actual' => $actual]);
    }

    /**
     * Validate the number of the items in coutable object
     *
     * @param int $items the computed array length
     * @return boolean true when the number of item is valid
     */
    protected abstract function isValid($items);

    /**
     * Get the uniq constraint name.
     *
     * @return string
     */
    protected abstract function getName();

}
