<?php


namespace Deployee\Components\Container;


interface ContainerAwareInterface
{
    /**
     * @param ContainerInterface $container
     */
    public function setContainer(ContainerInterface $container);
}