<?php

namespace Cohuatl\Lib;

class ArrayAccess implements \ArrayAccess, \IteratorAggregate
{
    protected $accessed = array();

    public function offsetExists ( $offset ) {
        return isset( $this->accessed[$offset] );
    }

    public function offsetGet ( $offset ) {
        return $this->offsetExists($offset) ? $this->accessed[$offset] : null;
    }

    public function offsetSet ( $offset , $value ) {
        $this->accessed[ $offset ] = $value;
    }

    public function offsetUnset ( $offset ) {
        if( isset( $this->accessed[ $offset ] ) ) {
            unset( $this->accessed[ $offset ] );
        }
    }

    final public function getIterator() {
        return new \ArrayIterator($this->accessed);
    }
}
