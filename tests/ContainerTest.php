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

    public function testExtend()
    {
        $container = new Container(['foo' => 1, 'addtofoo' => 5]);
        $container->extend('foo', function($value, ContainerInterface $c){
            return $value + $c->get('addtofoo');
        });

        $this->assertSame(6, $container->get('foo'));
    }
}