<?php

namespace FruitTest\CryptoKit;

use Fruit\CryptoKit\Base32;

class Base32Test extends \PHPUnit_Framework_TestCase
{
    public function base32P()
    {
        return array(
            array('12345', 'GEZDGNBV', 'minimal block'),
            array('1234512345', 'GEZDGNBVGEZDGNBV', 'more blocks'),
            array('123451', 'GEZDGNBVGE======', 'not aligned'),
            array('1', 'GE======', 'minimal non-aligned'),
            array('', '', 'empty'),
        );
    }

    /**
     * @dataProvider base32P
     */
    public function testBase32($src, $expect, $msg)
    {
        $mc = new Base32();
        $actual = $mc->encrypt($src);
        $this->assertEquals($expect, $actual, 'encrypt: ' . $msg);
        $actual = $mc->decrypt($actual);
        $this->assertEquals($src, $actual, 'decrypt: ' . $msg);
    }
}
