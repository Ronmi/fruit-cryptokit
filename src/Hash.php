<?php

namespace Fruit\CryptoKit;

class Hash implements Hasher
{
    private $algo;

    public function __construct($algo)
    {
        if (!in_array($algo, hash_algos())) {
            throw new \Exception(sprintf('Fruit\CryptoKit\Hash: %s is not supported on this machine.', $algo));
        }
        $this->algo = $algo;
    }

    public function sum($data)
    {
        return hash($this->algo, $data);
    }

    public function sumStream($handle)
    {
        $ctx = hash_init($this->algo);
        hash_update_stream($ctx, $handle);
        return hash_final($ctx);
    }
}
