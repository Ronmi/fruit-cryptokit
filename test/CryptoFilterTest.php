<?php

namespace FruitTest\CryptoKit;

use Fruit\CryptoKit\CryptoFilter;
use Fruit\CryptoKit\ROT13;

class CryptoFilterTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        // register filter
        $filters = stream_get_filters();
        if (!in_array('crypto.filter', $filters)) {
            stream_filter_register('crypto.filter', 'Fruit\CryptoKit\CryptoFilter');
        }
    }

    public function getStream($data)
    {
        $f = fopen('php://memory', 'w+');
        fputs($f, $data);
        rewind($f);
        return $f;
    }

    public function testEncrypt()
    {
        $data = 'qiwyfvbwefru09hi32059hinqf081';
        $expect = str_rot13($data);
        $f = $this->getStream($data);
        $crypter = new ROT13;
        stream_filter_append($f, 'crypto.filter', null, [
            'crypter' => $crypter,
            'crypt_type' => 'encrypt',
        ]);
        $actual = stream_get_contents($f);
        fclose($f);

        $this->assertEquals($expect, $actual);
    }

    public function testDecrypt()
    {
        $data = 'qiwyfvbwefru09hi32059hinqf081';
        $expect = str_rot13($data);
        $f = $this->getStream($data);
        $crypter = new ROT13;
        stream_filter_append($f, 'crypto.filter', null, [
            'crypter' => $crypter,
            'crypt_type' => 'decrypt',
        ]);
        $actual = stream_get_contents($f);
        fclose($f);

        $this->assertEquals($expect, $actual);
    }
}
