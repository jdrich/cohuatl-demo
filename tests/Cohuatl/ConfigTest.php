<?php

namespace tests\Cohuatl;

class ConfigTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructorThrowExceptionOnBadJson() {
        $this->setExpectedException( 'InvalidArgumentException' );

        $config = new \Cohuatl\Config( '{ "": }' );
    }

    public function testConstructorLoadsGoodJson() {
        $config = $this->getConfig();

        $this->assertEquals( $config['bacon'], 'indeed' );
    }

    public function testConfigReadonlySet() {
        $this->setExpectedException( 'BadMethodCallException' );

        $config = $this->getConfig();

        $config['foo'] = 'potato';
    }

    public function testConfigReadonlyUnset() {
        $this->setExpectedException( 'BadMethodCallException' );

        $config = $this->getConfig();

        unset($config['foo']);
    }

    private function getConfig() {
        return new \Cohuatl\Config( '{ "bacon": "indeed" }' );
    }
}
