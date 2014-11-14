<?php

namespace tests\Cohuatl\Lib;

class ArrayAccessTest extends \PHPUnit_Framework_TestCase
{
    public function testOffsetSet() {
        $access = $this->getArrayAccess();
    }

    public function testOffsetGet() {
        $access = $this->getArrayAccess();

        $this->assertEquals( $access['foo'], 'bar' );
        $this->assertEquals( $access['baz'], null );
    }

    public function testOffsetExists() {
        $access = $this->getArrayAccess();

        $this->assertTrue( isset($access['foo']) );
        $this->assertFalse( isset($access['baz']) );
    }


    public function testOffsetUnset() {
        $access = $this->getArrayAccess();

        unset( $access['foo'] );

        $this->assertTrue( !isset($access['foo']) );
    }

    private function getArrayAccess() {
        $access = new \Cohuatl\Lib\ArrayAccess();

        $access['foo'] = 'bar';

        return $access;
    }
}
