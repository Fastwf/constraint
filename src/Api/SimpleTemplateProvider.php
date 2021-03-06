<?php

namespace Fastwf\Constraint\Api;

use Fastwf\Constraint\Api\TemplateProvider;

/**
 * Default implementation of TemplateProvider that provide default strings to interpolate.
 */
class SimpleTemplateProvider implements TemplateProvider
{

    protected $templates = [
        'type' => 'Expect a value of \'%{type}\' type',
        'minLength' => 'The minimum length is %{length}, actually it is %{actual}',
        'maxLength' => 'The maximum length is %{length}, actually it is %{actual}',
        'pattern' => 'The value does not match %{pattern} pattern',
        'enum' => 'The value must be one of %{enum}',
        'format' => 'The value must respect the \'%{format}\' format',
        'blank' => 'The value must not be blank',
        'not-blank' => 'The value must be blank',
        'not' => 'Definition is valid',
        'allOf' => 'At least one definition is invalid',
        'anyOf' => 'All definitions are invalid',
        'oneOf' => 'None or more than one definition are valid',
        'min' => 'The value must be %{sign} %{minimum}',
        'max' => 'The value must be %{sign} %{maximum}',
        'multipleOf' => 'Expect a multiple of %{diviser}',
        'not-null' => '\'null\' value not allowed',
        'items' => 'Invalid item definition',
        'minItems' => 'The array must contains at least %{items} item(s), actually it is %{actual}',
        'maxItems' => 'The array must contains a maximum of %{items} item(s), actually it is %{actual}',
        'uniqueItems' => 'All items must be unique',
        'minProperties' => 'The object must contains at least %{properties} propertie(s), actually it is %{actual}',
        'maxProperties' => 'The object must contains a maximum of %{properties} propertie(s), actually it is %{actual}',
        'required' => 'The value is required',
    ];

    public function getTemplate($code)
    {
        if (\array_key_exists($code, $this->templates))
        {
            $template = $this->templates[$code];
        }
        else
        {
            $template = "Unknown error";
        }
        
        return $template;
    }

    /**
     * Register a string template to interpolate for the given error code.
     *
     * @param string $code the error code
     * @param string $template the template to register
     * @return void
     */
    public function setTemplate($code, $template)
    {
        $this->templates[$code] = $template;
    }

}
