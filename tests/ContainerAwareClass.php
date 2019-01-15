<?php


namespace Deployee\Components\Container;


class ContainerAwareClass implements ContainerAwareInterface
{
    use SetContainerTrait;

    public function getContainer(): ContainerInterface
    {
        return $this->container;
    }
}