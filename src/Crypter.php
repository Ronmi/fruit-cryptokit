<?php

namespace Fruit\CryptoKit;

/// A Crypter implementation MUST ALWAYS return raw binary string.
interface Crypter extends \Fruit\Module
{
    // These two methods should return raw binary string.
    public function encrypt($data);
    public function decrypt($data);

    // return negative number if not block cipher.
    public function getBlockSize();
}
