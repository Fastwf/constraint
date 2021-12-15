<?php

namespace Fastwf\Constraint\Build\Factory\OpenApi;

use Fastwf\Constraint\Constraints\Chain;
use Fastwf\Constraint\Constraints\String\Enum;
use Fastwf\Constraint\Constraints\String\Blank;
use Fastwf\Constraint\Exceptions\LoadException;
use Fastwf\Constraint\Constraints\String\Pattern;
use Fastwf\Constraint\Constraints\String\NotBlank;
use Fastwf\Constraint\Constraints\Type\StringType;
use Fastwf\Constraint\Constraints\String\MaxLength;
use Fastwf\Constraint\Constraints\String\MinLength;
use Fastwf\Constraint\Constraints\String\UriFormat;
use Fastwf\Constraint\Build\Environment\Environment;
use Fastwf\Constraint\Constraints\String\ByteFormat;
use Fastwf\Constraint\Constraints\String\DateFormat;
use Fastwf\Constraint\Constraints\String\IPv4Format;
use Fastwf\Constraint\Constraints\String\IPv6Format;
use Fastwf\Constraint\Constraints\String\TimeFormat;
use Fastwf\Constraint\Constraints\String\UuidFormat;
use Fastwf\Constraint\Constraints\String\DigitFormat;
use Fastwf\Constraint\Constraints\String\EmailFormat;
use Fastwf\Constraint\Constraints\String\BinaryFormat;
use Fastwf\Constraint\Build\Factory\OpenApi\AnyFactory;
use Fastwf\Constraint\Constraints\String\DateTimeFormat;
use Fastwf\Constraint\Constraints\String\HostnameFormat;
use Fastwf\Constraint\Constraints\String\Base64UrlFormat;
use Fastwf\Constraint\Build\Factory\OpenApi\StringFactory;

/**
 * String constraint factory.
 * 
 * Use #getDefault static method to obtain a ready to use open api StringFactory instance.
 */
class StringFactory extends AnyFactory
{

    /**
     * The map that contains the constraint class name assocated to the format name
     *
     * @var array
     */
    private $formatClass = [];

    protected function createType($schema)
    {
        $constraints = [];

        // Use the content constraint according to the priority
        $contentMethods = ['addFormatConstraint', 'addEnumConstraint', 'addPatternConstraint'];
        foreach ($contentMethods as $method) {
            if (\call_user_func_array([$this, $method], [$schema, &$constraints]))
            {
                break;
            }
        }

        // Add min/max length constraint
        $this->addMinLength($schema, $constraints);
        $this->addMaxLength($schema, $constraints);

        // Create the final constraint
        $constraint = new StringType();
        if (!empty($constraints))
        {
            $constraint = new Chain(
                true,
                $constraint,
                new Chain(false, ...$constraints),
            );
        }

        return $constraint;
    }

    /**
     * Add the format constraint to the constraint array and return true when it's set.
     * 
     * If the 'format' key is not found in schema, no constraint is added and false is returned.
     *
     * @param array $schema the schema specification to use to create the constraint.
     * @param array $constraints the array of constraint to populate
     * @return boolean true when the constraint is added, false otherwise.
     * @throws Fastwf\Constraint\Exceptions\LoadException
     */
    protected function addFormatConstraint($schema, &$constraints)
    {
        if (\array_key_exists('format', $schema))
        {
            $name = $schema['format'];
            if (\array_key_exists($name, $this->formatClass))
            {
                $constraints[] = new $this->formatClass[$name]();
            }
            else
            {
                throw new LoadException("Format '$name' not found");
            }

            return true;
        }

        return false;
    }

    /**
     * Add the enum constraint to the constraint array and return true when it's set.
     * 
     * If the 'enum' key is not found in schema, no constraint is added and false is returned.
     *
     * @param array $schema the schema specification to use to create the constraint.
     * @param array $constraints the array of constraint to populate
     * @return boolean true when the constraint is added, false otherwise.
     */
    protected function addEnumConstraint($schema, &$constraints)
    {
        if (\array_key_exists('enum', $schema))
        {
            $constraints[] = new Enum($schema['enum']);

            return true;
        }

        return false;
    }

    /**
     * Add the regex pattern constraint to the constraint array and return true when it's set.
     * 
     * If the 'pattern' key is not found in schema, no constraint is added and false is returned.
     *
     * @param array $schema the schema specification to use to create the constraint.
     * @param array $constraints the array of constraint to populate
     * @return boolean true when the constraint is added, false otherwise.
     */
    protected function addPatternConstraint($schema, &$constraints)
    {
        if (\array_key_exists('pattern', $schema))
        {
            $constraints[] = new Pattern($schema['pattern']);

            return true;
        }

        return false;
    }

    /**
     * Add the min length constraint when it's set in schema.
     *
     * @param array $schema the schema specification to use to create the constraint.
     * @param array $constraints the array of constraint to populate
     * @return void
     */
    protected function addMinLength($schema, &$constraints)
    {
        if (\array_key_exists('minLength', $schema))
        {
            $constraints[] = new MinLength($schema['minLength']);
        }
    }

    /**
     * Add the max length of constraint when it's set in schema.
     *
     * @param array $schema the schema specification to use to create the constraint.
     * @param array $constraints the array of constraint to populate
     * @return void
     */
    protected function addMaxLength($schema, &$constraints)
    {
        if (\array_key_exists('maxLength', $schema))
        {
            $constraints[] = new MaxLength($schema['maxLength']);
        }
    }

    /**
     * Set the constraint class associated to the format name.
     *
     * @param string $name the format name.
     * @param string $class the constraint class name.
     * @return void
     */
    public function setFormat($name, $class)
    {
        $this->formatClass[$name] = $class;
    }

    /**
     * Remove the constraint class associated to the format name.
     *
     * @param string $name the format name.
     * @return void
     */
    public function removeFormat($name)
    {
        if (isset($this->formatClass[$name]))
        {
            unset($this->formatClass[$name]);
        }
    }

    /**
     * Create a string constraint factory with default open api string format.
     *
     * @param Environment $env the current schema environment loader.
     * @return StringFactory the read to use StringFactory.
     */
    public static function getDefault($env)
    {
        $factory = new StringFactory($env);

        // Set all default format
        $factory->setFormat('date', DateFormat::class);
        $factory->setFormat('date-time', DateTimeFormat::class);
        $factory->setFormat('time', TimeFormat::class);
        $factory->setFormat('byte', ByteFormat::class);
        $factory->setFormat('base64url', Base64UrlFormat::class);
        $factory->setFormat('binary', BinaryFormat::class);
        $factory->setFormat('email', EmailFormat::class);
        $factory->setFormat('uuid', UuidFormat::class);
        $factory->setFormat('uri', UriFormat::class);
        $factory->setFormat('hostname', HostnameFormat::class);
        $factory->setFormat('ipv4', IPv4Format::class);
        $factory->setFormat('ipv6', IPv6Format::class);
        $factory->setFormat('digit', DigitFormat::class);
        $factory->setFormat('blank', Blank::class);
        $factory->setFormat('not-blank', NotBlank::class);

        return $factory;
    }

}
