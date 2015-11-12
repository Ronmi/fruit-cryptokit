<?php

namespace FruitTest\CryptoKit;

use Fruit\CryptoKit\ROT13;

class ROT13Test extends \PHPUnit_Framework_TestCase
{
    public function testROT13()
    {
        $mc = new ROT13();
        $expect = 'test';
        $actual = $mc->encrypt($expect);
        $this->assertNotEquals($expect, $actual);
        $actual = $mc->decrypt($actual);
        $this->assertEquals($expect, $actual);
    }
}
