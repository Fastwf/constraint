<?php

namespace Fastwf\Tests\Data;

use Fastwf\Tests\Model\Data;
use PHPUnit\Framework\TestCase;

use Fastwf\Constraint\Data\Node;
use Fastwf\Constraint\Data\ObjectNode;
use Fastwf\Constraint\Exceptions\NodeException;


class ObjectNodeTest extends TestCase
{

    private $parent;
    private $data;

    protected function setUp(): void
    {
        $this->parent = new Data();
        $this->parent->setRoot(true);

        $data = new Data();
        $data->name = 'child';
        $data->setParent($this->parent);
        $data->setAlive(true);
        $data->setRoot(false);

        $data->setSuper('super');
        $data->setSuperParent('superParent');

        $this->data = $data;
    }

    /**
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\ObjectNode
     * @covers Fastwf\Constraint\Reflection\Property
     * @covers Fastwf\Constraint\Reflection\UndefinedProperty
     */
    public function testNodeFrom()
    {
        $node = Node::from(['value' => $this->data]);

        $this->assertTrue($node instanceof ObjectNode);
    }

    /**
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\ObjectNode
     * @covers Fastwf\Constraint\Reflection\Property
     * @covers Fastwf\Constraint\Reflection\UndefinedProperty
     */
    public function testNull()
    {
        $node = new ObjectNode();

        $this->assertFalse($node->name->isDefined());
    }

    /**
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\ObjectNode
     * @covers Fastwf\Constraint\Reflection\Property
     * @covers Fastwf\Constraint\Reflection\PublicProperty
     */
    public function testGet()
    {
        $node = new ObjectNode(['value' => $this->data]);

        $this->assertEquals('child', $node->name->get());
    }

    /**
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\ObjectNode
     * @covers Fastwf\Constraint\Reflection\Property
     * @covers Fastwf\Constraint\Reflection\StdProperty
     * @covers Fastwf\Constraint\Reflection\Method
     * @covers Fastwf\Constraint\Reflection\UndefinedGetterMethod
     */
    public function testGetSuper()
    {
        $node = new ObjectNode(['value' => $this->data]);

        $this->assertEquals('super', $node->super->get());
    }

    /**
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\ObjectNode
     * @covers Fastwf\Constraint\Reflection\Property
     * @covers Fastwf\Constraint\Reflection\StdProperty
     * @covers Fastwf\Constraint\Reflection\UndefinedGetterMethod
     */
    public function testGetUndefined()
    {
        $node = new ObjectNode(['value' => $this->data]);

        $this->assertFalse($node->any->isDefined());
    }

    /**
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\ObjectNode
     * @covers Fastwf\Constraint\Reflection\Property
     * @covers Fastwf\Constraint\Reflection\PublicProperty
     */
    public function testSetPublic()
    {
        $node = new ObjectNode(['value' => $this->data]);

        $node->name = 'public';

        $this->assertEquals('public', $this->data->name);
    }

    /**
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\ObjectNode
     * @covers Fastwf\Constraint\Reflection\Property
     * @covers Fastwf\Constraint\Reflection\StdProperty
     * @covers Fastwf\Constraint\Reflection\Method
     */
    public function testSetInaccessible()
    {
        $node = new ObjectNode(['value' => $this->data]);

        $node->root = true;

        $this->assertTrue($this->data->isRoot());
    }

    /**
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\ObjectNode
     * @covers Fastwf\Constraint\Reflection\Property
     * @covers Fastwf\Constraint\Reflection\StdProperty
     * @covers Fastwf\Constraint\Reflection\Method
     * @covers Fastwf\Constraint\Reflection\UndefinedSetterMethod
     */
    public function testSetSuper()
    {
        $node = new ObjectNode(['value' => $this->data]);

        $node->super = 'SUPPER';

        $this->assertEquals('SUPPER', $node->super->get());
    }

    /**
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\ObjectNode
     * @covers Fastwf\Constraint\Reflection\Property
     * @covers Fastwf\Constraint\Reflection\StdProperty
     * @covers Fastwf\Constraint\Reflection\UndefinedSetterMethod
     */
    public function testSetUndefined()
    {
        $this->expectException(NodeException::class);

        $node = new ObjectNode(['value' => $this->data]);

        $node->any = 'public';
    }

    /**
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\ObjectNode
     * @covers Fastwf\Constraint\Reflection\Property
     * @covers Fastwf\Constraint\Reflection\PublicProperty
     * @covers Fastwf\Constraint\Reflection\StdProperty
     * @covers Fastwf\Constraint\Reflection\StdProperty
     * @covers Fastwf\Constraint\Reflection\UndefinedGetterMethod
     * @covers Fastwf\Constraint\Reflection\Method
     */
    public function testIsset()
    {
        $node = new ObjectNode(['value' => $this->data]);

        $node->name->get();
        $node->undefined->get();

        // Test cached value
        $this->assertTrue(isset($node->name));
        $this->assertTrue(isset($node->superParent));
        $this->assertFalse(isset($node->undefined));
        // Test not cached values
        $this->assertTrue(isset($node->root));
        $this->assertTrue(isset($node->isAlive));
        $this->assertTrue(isset($node->children));
        $this->assertFalse(isset($node->any));
        $this->assertFalse(isset($node->internal));
    }

    /**
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\ObjectNode
     * @covers Fastwf\Constraint\Reflection\Property
     * @covers Fastwf\Constraint\Reflection\StdProperty
     * @covers Fastwf\Constraint\Reflection\Method
     */
    public function testGetObjectNode()
    {
        $node = new ObjectNode(['value' => $this->data]);

        $this->assertTrue($node->parent instanceof ObjectNode);
    }

    /**
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\ObjectNode
     */
    public function testGetIteratorNullValue()
    {
        $node = new ObjectNode(['value' => null]);

        $this->assertTrue(empty(\iterator_to_array($node->getIterator())));
    }

    /**
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\ObjectNode
     * @covers Fastwf\Constraint\Reflection\Method
     * @covers Fastwf\Constraint\Reflection\Property
     * @covers Fastwf\Constraint\Reflection\PublicProperty
     * @covers Fastwf\Constraint\Reflection\StdProperty
     * @covers Fastwf\Constraint\Utils\Iterators\ObjectNodeIterator
     */
    public function testGetIterator()
    {
        $node = new ObjectNode(['value' => $this->data]);
        
        $nodes = \iterator_to_array($node->getIterator());

        $this->assertEquals('super', $nodes['super']->get());
    }

    /**
     * @covers Fastwf\Constraint\Data\Node
     * @covers Fastwf\Constraint\Data\ObjectNode
     * @covers Fastwf\Constraint\Reflection\Method
     * @covers Fastwf\Constraint\Reflection\Property
     * @covers Fastwf\Constraint\Reflection\PublicProperty
     * @covers Fastwf\Constraint\Reflection\StdProperty
     * @covers Fastwf\Constraint\Utils\Iterators\ObjectNodeIterator
     */
    public function testGetBuiltIn()
    {
        $node = new ObjectNode(['value' => $this->data]);

        $this->assertEquals(
            [
                'name' => 'child',
                'parent' => [
                    'name' => null,
                    'parent' => null,
                    'root' => true,
                    'isAlive' => null,
                    'children' => null,
                    'superParent' => null,
                    'super' => null,
                ],
                'root' => false,
                'isAlive' => true,
                'children' => null,
                'superParent' => 'superParent',
                'super' => 'super',
            ],
            $node->getBuiltIn(),
        );
    }

}
