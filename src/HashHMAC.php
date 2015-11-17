<?php

namespace Fruit\CryptoKit;

class HashHMAC implements Hasher
{
    private $hash;
    private $needReset;

    public function __construct(Hasher $hash, $key, $blockSize)
    {
        $this->hash = $hash;
        if (strlen($key) > $blockSize) {
            $key = $this->hash->update($key)->sum(true);
        }
        $key = str_pad($key, $blockSize, "\0");

        $okey = str_repeat(chr(0x5c), $blockSize) ^ $key;
        $ikey = str_repeat(chr(0x36), $blockSize) ^ $key;

        $this->outer = $okey;
        $this->inner = $ikey;
        $this->needReset = true;
    }

    protected function init()
    {
        if ($this->needReset) {
            $this->needReset = false;
            $this->hash->update($this->inner);
        }
    }

    public function update($data)
    {
        $this->init();
        $this->hash->update($data);
        return $this;
    }

    public function updateStream($handle)
    {
        $this->init();
        $this->hash->updateStream($handle);
        return $this;
    }

    public function sum($raw = false) {
        $this->needReset = true;

        $tmp = $this->hash->sum(true);
        $this->hash->update($this->outer);
        $this->hash->update($tmp);
        return $this->hash->sum($raw);
    }
}
