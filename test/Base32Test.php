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
        $encoded = $mc->encrypt($src);
        $this->assertEquals($expect, $encoded, 'encrypt: ' . $msg);
        $actual = $mc->decrypt($encoded);
        $this->assertEquals($src, $actual, 'decrypt: ' . $msg);
        $actual = $mc->decrypt(strtolower($encoded));
        $this->assertEquals($src, $actual, 'decrypt(lower): ' . $msg);
    }

    /**
     * @dataProvider base32P
     */
    public function testBase32Static($src, $expect, $msg)
    {
        $encoded = Base32::E($src);
        $this->assertEquals($expect, $encoded, 'encrypt: ' . $msg);
        $actual = Base32::D($encoded);
        $this->assertEquals($src, $actual, 'decrypt: ' . $msg);
        $actual = Base32::D(strtolower($encoded));
        $this->assertEquals($src, $actual, 'decrypt(lower): ' . $msg);
   }
}
