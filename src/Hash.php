<?php

namespace Fruit\CryptoKit;

class Hash implements Hasher
{
    private $algo;
    private $ctx;

    public function __construct($algo)
    {
        if (!in_array($algo, hash_algos())) {
            throw new \Exception(sprintf('Fruit\CryptoKit\Hash: %s is not supported on this machine.', $algo));
        }
        $this->algo = $algo;
        $this->ctx = null;
    }

    protected function init()
    {
        if ($this->ctx === null) {
            $this->ctx = hash_init($this->algo);
        }
    }

    public function update($data)
    {
        $this->init();
        hash_update($this->ctx, $data);
        return $this;
    }

    public function updateStream($handle)
    {
        $this->init();
        hash_update_stream($this->ctx, $handle);
        return $this;
    }

    public function sum($raw = false)
    {
        $this->init();
        $ret = hash_final($this->ctx, $raw);
        $this->ctx = null;
        return $ret;
    }
}
