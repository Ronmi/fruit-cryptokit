<?php

namespace FruitTest\CryptoKit;

use Fruit\CryptoKit\Hash;
use Fruit\CryptoKit\HashHMAC;

class HashHMACTest extends \PHPUnit_Framework_TestCase
{
    const KEY = 'ogc';

    public function testHash()
    {
        $h = new HashHMAC(new Hash('md5'), self::KEY, 64);
        $data = 'giwbhkd80yhoin23rf08hi';
        $expect = hash_hmac('md5', $data, self::KEY);
        $actual = $h->update(substr($data, 0, 10))->update(substr($data, 10))->sum();
        $this->assertEquals($expect, $actual);
    }

    public function testHashStream()
    {
        $h = new HashHMAC(new Hash('md5'), self::KEY, 64);
        $expect = hash_hmac_file('md5', __FILE__, self::KEY);
        $f = fopen(__FILE__, 'r');
        $actual = $h->updateStream($f)->sum();
        $this->assertEquals($expect, $actual);
    }
}
