<?php

namespace Fruit\CryptoKit;

class ROT13 implements Crypter
{
    public static function __set_state(array $props)
    {
        return new self;
    }

    public function encrypt($data)
    {
        return str_rot13($data);
    }

    public function decrypt($data)
    {
        return str_rot13($data);
    }

    public function getEncryptBlockSize()
    {
        return 1;
    }
    public function getDecryptBlockSize()
    {
        return 1;
    }
}
