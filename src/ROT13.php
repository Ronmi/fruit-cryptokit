<?php

namespace Fruit\CryptoKit;

class ROT13 implements Crypter
{
    use \Fruit\ModuleTrait;

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

    public function getBlockSize()
    {
        return 1;
    }
}
