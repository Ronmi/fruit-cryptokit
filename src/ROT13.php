<?php

namespace Fruit\CryptoKit;

class ROT13 implements Crypter
{
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
