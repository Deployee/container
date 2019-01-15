<?php


namespace Deployee\Components\Container;


use PHPUnit\Framework\TestCase;

class SetContainerTraitTest extends TestCase
{
    /**
     * @throws ContainerException
     */
    public function testSetContainer()
    {
        $container = new Container();
        $object = new ContainerAwareClass();
        $object->setContainer($container);

        $this->assertSame($container, $object->getContainer());
    }
}