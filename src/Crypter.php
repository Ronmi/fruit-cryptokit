<?php

namespace Fruit\CryptoKit;

interface Crypter
{
    public function encrypt($data);
    public function decrypt($data);

    // return negative number if not block cipher
    public function getBlockSize();
}
