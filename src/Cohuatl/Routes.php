<?php

namespace Cohuatl;

abstract class Routes implements \IteratorAggregate
{
    protected $routes = array();

    final public function getIterator() {
        return new \ArrayIterator($this->routes);
    }
}
