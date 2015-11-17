<?php

use Fruit\BenchKit\Benchmark;
use Fruit\CryptoKit\HashHMAC;
use Fruit\CryptoKit\Hash;

class HMAC
{
    const DATA = '2g80hifb823guobjf0qwhfipbq180uhipjdf-9fhdohq09wfyhiqw09fyhiqwf-9yhqf';
    const KEY = 'ogcogcogcogcogcogcogcogcogcogcogcogcogcogcogcogcogcogcogc';

    public function HashExtension(Benchmark $b)
    {
        for ($i = 0; $i < $b->n; $i++) {
            hash_hmac('md5', self::DATA, self::KEY);
        }
    }

    public function PurePHP(Benchmark $b)
    {
        for ($i = 0; $i < $b->n; $i++) {
            $key = self::KEY;
            if (strlen($key) > 64) {
                $key = md5($key, true);
            }
            $key = str_pad($key, 64, "\0");
            $okey = str_repeat(chr(0x5c), 64) ^ $key;
            $ikey = str_repeat(chr(0x5c), 64) ^ $key;
            md5($okey . md5($ikey . self::DATA, true));
        }
    }

    public function CryptoKit(Benchmark $b)
    {
        for ($i = 0; $i < $b->n; $i++) {
            $h = new HashHMAC(new Hash('md5'), self::KEY, 64);
            $h->update(self::DATA)->sum();
        }
    }
}
