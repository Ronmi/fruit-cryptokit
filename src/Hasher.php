<?php

namespace Fruit\CryptoKit;

interface Hasher
{
    public function sum($data);

    public function sumStream($handle);
}
