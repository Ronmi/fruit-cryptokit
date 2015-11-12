<?php

namespace Fruit\CryptoKit;

interface Crypter
{
    public function encrypt($data);
    public function decrypt($data);
}
