<?php

namespace FruitTest\CryptoKit;

use Fruit\CryptoKit\Hash;

class HashTest extends \PHPUnit_Framework_TestCase
{
    public function testHash()
    {
        $h = new Hash('md5');
        $data = 'giwbhkd80yhoin23rf08hi';
        $expect = md5($data);
        $actual = $h->sum($data);
        $this->assertEquals($expect, $actual);
    }

    public function testHashStream()
    {
        $h = new Hash('md5');
        $expect = md5_file(__FILE__);
        $f = fopen(__FILE__, 'r');
        $actual = $h->sumStream($f);
        $this->assertEquals($expect, $actual);
    }
}
