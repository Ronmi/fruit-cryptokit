<?php

namespace Fruit\CryptoKit;

class MockCrypter implements Crypter
{
    public function encrypt($data)
    {
        return $data;
    }

    public function decrypt($data)
    {
        return $data;
    }
}
