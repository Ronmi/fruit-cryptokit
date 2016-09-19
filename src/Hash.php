<?php

namespace Fruit\CryptoKit;

// place redundent codes in update(), updateStream() and sum() to prevent
// function call when initializing.
class Hash implements Hasher
{
    private $algo;
    private $ctx;

    public function __construct($algo)
    {
        if (!in_array($algo, hash_algos())) {
            throw new \Exception(
                sprintf('Fruit\CryptoKit\Hash: %s is not supported on this machine.', $algo)
            );
        }
        $this->algo = $algo;
        $this->ctx = null;
    }

    public function compile()
    {
        return $this->toCompile(array('algo' => $this->algo));
    }

    public static function __set_state(array $props)
    {
        return new self($props['algo']);
    }

    public function update($data)
    {
        if ($this->ctx === null) {
            $this->ctx = hash_init($this->algo);
        }
        hash_update($this->ctx, $data);
        return $this;
    }

    public function updateStream($handle)
    {
        if ($this->ctx === null) {
            $this->ctx = hash_init($this->algo);
        }
        hash_update_stream($this->ctx, $handle);
        return $this;
    }

    public function sum($raw = false)
    {
        if ($this->ctx === null) {
            $this->ctx = hash_init($this->algo);
        }
        $ret = hash_final($this->ctx, $raw);
        $this->ctx = null;
        return $ret;
    }
}
