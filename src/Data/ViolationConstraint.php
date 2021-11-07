<?php

namespace Fastwf\Constraint\Data;

/**
 * A data object that contains validation constraint information.
 */
class ViolationConstraint
{

    /**
     * The uniq code corresponding to the constraint.
     *
     * @var string
     */
    private $code;

    /**
     * The parameter array containing informations about constraint.
     *
     * @var array
     */
    private $parameters;

    /**
     * A formatted message corresponding to the $code and $parameters.
     *
     * @var string
     */
    private $message;

    public function __construct($code, $parameters)
    {
        $this->code = $code;
        $this->parameters = $parameters;
    }

    /**
     * Getter for uniq constraint code.
     *
     * @return string the code
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Getter for constraint violation information.
     *
     * @return array informations
     */
    public function getParameters()
    {
        return $this->code;
    }

    /**
     * Set the message associated to this violation constraint.
     *
     * @param string $message the message to set.
     * @return void
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * Get the current saved message.
     *
     * @return string the human readable constraint violation message.
     */
    public function getMessage()
    {
        return $this->message;
    }

}
