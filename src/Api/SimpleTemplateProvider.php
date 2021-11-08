<?php

namespace Fastwf\Constraint\Api;

use Fastwf\Constraint\Api\TemplateProvider;

/**
 * Default implementation of TemplateProvider that provide default strings to interpolate.
 */
class SimpleTemplateProvider implements TemplateProvider
{

    protected $templates = [];

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
