<?php

namespace Fruit\CryptoKit;

// place redundent codes in update() and updateStream() to prevent function call
// when initializing.
class HashHMAC implements Hasher
{
    private $hash;
    private $key;
    private $blockSize;
    private $needReset;

    public function __construct(Hasher $hash, $key, $blockSize)
    {
        $this->hash = $hash;
        $this->key = $key;
        $this->blockSize = $blockSize;
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

    public static function __set_state(array $props)
    {
        return new self($props['hash'], $props['key'], $props['blockSize']);
    }

    public function update($data)
    {
        if ($this->needReset) {
            $this->needReset = false;
            $this->hash->update($this->inner);
        }
        $this->hash->update($data);
        return $this;
    }

    public function updateStream($handle)
    {
        if ($this->needReset) {
            $this->needReset = false;
            $this->hash->update($this->inner);
        }
        $this->hash->updateStream($handle);
        return $this;
    }

    public function sum($raw = false)
    {
        $this->needReset = true;

        $tmp = $this->hash->sum(true);
        $this->hash->update($this->outer . $tmp);
        return $this->hash->sum($raw);
    }
}
