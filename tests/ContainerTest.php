<?php


namespace Deployee\Components\Container;


use PHPUnit\Framework\TestCase;

class ContainerTest extends TestCase
{
    public function testSetGet()
    {
        $container = new Container(['foo' => 1, 'bar' => function(){return 'foobar';}]);
        $container->set('barfoo', new \stdClass());

        $this->assertSame(1, $container->get('foo'));
        $this->assertSame('foobar', $container->get('bar'));
        $this->assertInstanceOf(\stdClass::class, $container->get('barfoo'));
    }

    public function testSetFail()
    {
        $container = new Container(['foo' => 1]);

        $this->expectException(ContainerException::class);
        $container->set('foo', 2);
    }

    public function testGetFail()
    {
        $container = new Container();
        $this->expectException(ContainerException::class);
        $container->get('foo');
    }

    public function testExtend()
    {
        $object = new \stdClass();
        $object->bar = 1;

        $container = new Container(['foo' => $object, 'addtofoo' => 5]);
        $container->extend('foo', function(\stdClass $foo, ContainerInterface $c){
            return $foo->bar + $c->get('addtofoo');
        });

        $extended = $container->get('foo');
        $this->assertSame(6, $extended);
    }

    public function testReplaceObject()
    {
        $objectOne = new \stdClass();
        $objectOne->bar = 1;

        $objectTwo = new \stdClass();
        $objectTwo->bar = 1337;

        $container = new Container(['object' => $objectOne]);
        $container->extend('object', function() use($objectTwo){
            return $objectTwo;
        });

        $this->assertSame($objectTwo, $container->get('object'));
    }
}