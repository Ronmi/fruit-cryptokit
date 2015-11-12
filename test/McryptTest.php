<?php

namespace FruitTest\CryptoKit;

use Fruit\CryptoKit\Mcrypt;

class McryptTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @requires extension mcrypt
     */
    public function testMcrypt()
    {
        $mc = new Mcrypt(\MCRYPT_3DES, 'my secret key need 24 bs', 'ecb');
        $expect = 'test';
        $actual = $mc->encrypt($expect);
        $this->assertNotEquals($expect, $actual);
        $actual = $mc->decrypt($actual);
        $this->assertEquals($expect, $actual);
    }
}
