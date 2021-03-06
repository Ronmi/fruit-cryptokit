<?php

namespace Fruit\CryptoKit;

class MockCrypter implements Crypter
{
    private $blockSize;

    public function __construct($blockSize = -1)
    {
        $this->blockSize = $blockSize;
    }

    public static function __set_state(array $props)
    {
        return new self($props['blockSize']);
    }

    public function encrypt($data)
    {
        return $data;
    }

    public function decrypt($data)
    {
        return $data;
    }

    public function getEncryptBlockSize()
    {
        return $this->blockSize;
    }
    public function getDecryptBlockSize()
    {
        return $this->blockSize;
    }
}
