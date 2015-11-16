<?php

namespace Fruit\CryptoKit;

class MockCrypter implements Crypter
{
    private $blockSize;

    public function __construct($blockSize = -1)
    {
        $this->blockSize = $blockSize;
    }

    public function encrypt($data)
    {
        return $data;
    }

    public function decrypt($data)
    {
        return $data;
    }

    public function getBlockSize()
    {
        return $this->blockSize;
    }
}
