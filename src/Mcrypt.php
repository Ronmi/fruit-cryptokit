<?php

namespace Fruit\CryptoKit;

class Mcrypt implements Crypter
{
    private $cipher;
    private $key;
    private $mode;
    private $iv;

    public function __construct($cipher, $key, $mode, $iv = null)
    {
        $this->cipher = $cipher;
        $this->key = $key;
        $this->mode = $mode;
        $ivsize = mcrypt_get_iv_size($cipher, $mode);
        if ($iv === null and $ivsize > 0) {
            $iv = mcrypt_create_iv($ivsize);
        }
        $this->iv = $iv;
    }

    public function encrypt($data)
    {
        return mcrypt_encrypt($this->cipher, $this->key, $data, $this->mode, $this->iv);
    }

    public function decrypt($data)
    {
        $ret = mcrypt_decrypt($this->cipher, $this->key, $data, $this->mode, $this->iv);
        for ($i = strlen($ret) - 1; $i >= 0; $i--) {
            if (substr($ret, $i, 1) != "\x0") {
                $ret = substr($ret, 0, $i+1);
                break;
            }
        }
        return $ret;
    }
}
