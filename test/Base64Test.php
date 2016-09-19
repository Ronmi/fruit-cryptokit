<?php

namespace FruitTest\CryptoKit;

use Fruit\CryptoKit\Base64;

class Base64Test extends \PHPUnit_Framework_TestCase
{
    public function base64P()
    {
        return array(
            array('123', 'MTIz', 'minimal block'),
            array('123123', 'MTIzMTIz', 'more blocks'),
            array('1231', 'MTIzMQ==', 'not aligned'),
            array('1', 'MQ==', 'minimal non-aligned'),
            array('', '', 'empty'),
        );
    }

    /**
     * @dataProvider base64P
     */
    public function testBase64($src, $expect, $msg)
    {
        $mc = new Base64();
        $actual = $mc->encrypt($src);
        $this->assertEquals($expect, $actual, 'encrypt: ' . $msg);
        $actual = $mc->decrypt($actual);
        $this->assertEquals($src, $actual, 'decrypt: ' . $msg);
    }
}
