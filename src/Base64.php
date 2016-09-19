<?php

namespace Fruit\CryptoKit;

class Base64 implements Crypter
{
    public function encrypt($data)
    {
        return base64_encode($data);
    }

    public function decrypt($data)
    {
        return base64_decode($data);
    }

    public function getEncryptBlockSize()
    {
        return 3; // 3 bytes plain text => 4 bytes crypted text
    }
    public function getDecryptBlockSize()
    {
        return 4; // 4 bytes crypted text => 3 bytes plain text
    }
}
