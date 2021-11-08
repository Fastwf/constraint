<?php

namespace Fastwf\Tests\Api;

use PHPUnit\Framework\TestCase;
use Fastwf\Constraint\Api\SimpleTemplateProvider;

class SimpleTemplateProviderTest extends TestCase
{
    
    /**
     * @covers Fastwf\Constraint\Api\SimpleTemplateProvider
     */
    public function testSetGetTemplate()
    {
        $code = 'type';
        $template = 'The expected type is %{type}';

        $provider = new SimpleTemplateProvider();
        $provider->setTemplate($code, $template);

        $this->assertEquals($template, $provider->getTemplate($code));
    }

    /**
     * @covers Fastwf\Constraint\Api\SimpleTemplateProvider
     */
    public function testGetTemplateUnknown()
    {
        $provider = new SimpleTemplateProvider();

        $this->assertEquals('Unknown error', $provider->getTemplate('undefined'));
    }

}