<?php

namespace Fastwf\Constraint\Api;

/**
 * The interface that allows to provide a string template from error code.
 */
interface TemplateProvider
{

    /**
     * Provide a string template to interpolate associated to the error $code.
     *
     * @param string $code the error code provided by constraint.
     * @return string the string template.
     */
    public function getTemplate($code);

}
