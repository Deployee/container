<?php

namespace Deployee\Components\Container;

class Container implements ContainerInterface
{
    /**
     * @var \Pimple\Container
     */
    private $container;

    /**
     * @param array $values
     * @throws ContainerException
     */
    public function __construct(array $values = array())
    {
        $this->container = new \Pimple\Container();
        foreach ($values as $id => $value){
            $this->set($id, $value);
        }
    }

    /**
     * @param string $id
     * @return mixed
     */
    public function get(string $id)
    {
        return $this->container[$id];
    }

    /**
     * @param string $id
     * @param mixed $value
     * @return void
     * @throws ContainerException
     */
    public function set(string $id, $value)
    {
        if(isset($this->container[$id])){
            throw new ContainerException(sprintf(
                'Element with id %s already exists. You must use "extend" to modify the value',
                $id
            ));
        }

        if(is_callable($value)){
            $me = $this;
            $result = function() use($value, $me){
                return $value($me);
            };

            $value = $result;
        }

        $this->container[$id] = $value;
    }

    /**
     * @param string $id
     * @param callable $callable
     */
    public function extend(string $id, callable $callable)
    {
        $me = $this;
        $value = $me->get($id);
        $this->container[$id] = function() use($callable, $me, $value){
            return $callable($value, $me);
        };
    }
}