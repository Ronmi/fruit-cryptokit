<?php

use Fruit\BenchKit\Benchmark;
use Fruit\CryptoKit\Base32;
use Fruit\CryptoKit\Hash;

class Base32Decrypt
{
    private $b;
    public function __construct()
    {
        $this->b = new Base32;
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

    public function StaticDecryptLess(Benchmark $b)
    {
        $code = $this->b->encrypt('1');
        $b->reset();
        for ($i = 0; $i < $b->n; $i++) {
            Base32::D($code);
        }
    }
    public function StaticDecryptBlock(Benchmark $b)
    {
        $code = $this->b->encrypt('12345');
        $b->reset();
        for ($i = 0; $i < $b->n; $i++) {
            Base32::D($code);
        }
    }
    public function StaticDecryptMore(Benchmark $b)
    {
        $code = $this->b->encrypt('123456');
        $b->reset();
        for ($i = 0; $i < $b->n; $i++) {
            Base32::D($code);
        }
    }
    public function StaticDecrypt30cm(Benchmark $b)
    {
        $data = 'KNSUOVSVLI4W222LGZ2FK5TOG4ZDOZDJNZKEI3CVMN3TSQRVK5YXO6KBKFGECT3NJBWTOODEKFCHIVJZIJNHK4LTOJXU45KCLFNESNTCONGS6RTIGN5GOUZXJF2GIZRZMQ3WKSDZJEYWSODBIV3USOLHIZVGEYLDINYEEVZSMIYVIUTEG54VIRKFOJEXUTJLHFWSWQSNKVCHSOLKOBFEQQTRJ5BXI2L2IFKUOY2FK43XM6CEMVFXCS3BPAVWWRCB';
        for ($i = 0; $i < $b->n; $i++) {
            Base32::D($data);
        }
    }
}
