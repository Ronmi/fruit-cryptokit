<?php

use Fruit\BenchKit\Benchmark;
use Fruit\CryptoKit\Base32;
use Fruit\CryptoKit\Hash;

class Base32Bench
{
    private $b;
    public function __construct()
    {
        $this->b = new Base32;
    }

    public function EncryptLess(Benchmark $b)
    {
        for ($i = 0; $i < $b->n; $i++) {
            $this->b->encrypt('1');
        }
    }
    public function EncryptBlock(Benchmark $b)
    {
        for ($i = 0; $i < $b->n; $i++) {
            $this->b->encrypt('12345');
        }
    }
    public function EncryptMore(Benchmark $b)
    {
        for ($i = 0; $i < $b->n; $i++) {
            $this->b->encrypt('123456');
        }
    }
    public function DecryptLess(Benchmark $b)
    {
        $code = $this->b->encrypt('1');
        $b->reset();
        for ($i = 0; $i < $b->n; $i++) {
            $this->b->decrypt($code);
        }
    }
    public function DecryptBlock(Benchmark $b)
    {
        $code = $this->b->encrypt('12345');
        $b->reset();
        for ($i = 0; $i < $b->n; $i++) {
            $this->b->decrypt($code);
        }
    }
    public function DecryptMore(Benchmark $b)
    {
        $code = $this->b->encrypt('123456');
        $b->reset();
        for ($i = 0; $i < $b->n; $i++) {
            $this->b->decrypt($code);
        }
    }
}
