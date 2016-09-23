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
    public function Encrypt30cm(Benchmark $b)
    {
        $data = 'SeGVUZ9mkK6tUvn727dinTDlUcw9B5WqwyAQLAOmHm78dQDtU9BZuqsroNuBYZI6bsM/Fh3zgS7Itdf9d7eHyI1i8aEwI9gFjbacCpBW2b1TRd7yTEErIzM+9m+BMUDy9jpJHBqOCtizAUGcEW7vxDeKqKax+kDA';
        for ($i = 0; $i < $b->n; $i++) {
            $this->b->encrypt($data);
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
    public function Decrypt30cm(Benchmark $b)
    {
        $data = 'KNSUOVSVLI4W222LGZ2FK5TOG4ZDOZDJNZKEI3CVMN3TSQRVK5YXO6KBKFGECT3NJBWTOODEKFCHIVJZIJNHK4LTOJXU45KCLFNESNTCONGS6RTIGN5GOUZXJF2GIZRZMQ3WKSDZJEYWSODBIV3USOLHIZVGEYLDINYEEVZSMIYVIUTEG54VIRKFOJEXUTJLHFWSWQSNKVCHSOLKOBFEQQTRJ5BXI2L2IFKUOY2FK43XM6CEMVFXCS3BPAVWWRCB';
        for ($i = 0; $i < $b->n; $i++) {
            $this->b->decrypt($data);
        }
    }
}
