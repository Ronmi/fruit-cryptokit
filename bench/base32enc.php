<?php

use Fruit\BenchKit\Benchmark;
use Fruit\CryptoKit\Base32;
use Fruit\CryptoKit\Hash;

class Base32Encrypt
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
    public function Encrypt30cm(Benchmark $b)
    {
        $data = 'SeGVUZ9mkK6tUvn727dinTDlUcw9B5WqwyAQLAOmHm78dQDtU9BZuqsroNuBYZI6bsM/Fh3zgS7Itdf9d7eHyI1i8aEwI9gFjbacCpBW2b1TRd7yTEErIzM+9m+BMUDy9jpJHBqOCtizAUGcEW7vxDeKqKax+kDA';
        for ($i = 0; $i < $b->n; $i++) {
            $this->b->encrypt($data);
        }
    }

    public function StaticEncryptLess(Benchmark $b)
    {
        for ($i = 0; $i < $b->n; $i++) {
            Base32::E('1');
        }
    }
    public function StaticEncryptBlock(Benchmark $b)
    {
        for ($i = 0; $i < $b->n; $i++) {
            Base32::E('12345');
        }
    }
    public function StaticEncryptMore(Benchmark $b)
    {
        for ($i = 0; $i < $b->n; $i++) {
            Base32::E('123456');
        }
    }
    public function StaticEncrypt30cm(Benchmark $b)
    {
        $data = 'SeGVUZ9mkK6tUvn727dinTDlUcw9B5WqwyAQLAOmHm78dQDtU9BZuqsroNuBYZI6bsM/Fh3zgS7Itdf9d7eHyI1i8aEwI9gFjbacCpBW2b1TRd7yTEErIzM+9m+BMUDy9jpJHBqOCtizAUGcEW7vxDeKqKax+kDA';
        for ($i = 0; $i < $b->n; $i++) {
            Base32::E($data);
        }
    }
}
