<?php

namespace Fruit\CryptoKit;

class Mcrypt implements Crypter
{
    private $module;
    private $key;
    private $iv;

    public function __construct($cipher, $key, $mode, $iv = null)
    {
        $this->module = mcrypt_module_open($cipher, '', $mode, '');
        if (strlen($key) > mcrypt_enc_get_key_size($this->module)) {
            throw new \Exception(sprintf(
                'Fruit\CryptoKit\Mcrypt: Key size for %s-%s is %d',
                $cipher, $mode, mcrypt_enc_get_key_size($this->module)
            ));
        }
        $this->key = $key;
        $ivsize = mcrypt_enc_get_iv_size($this->module);
        if ($iv === null and $ivsize > 0) {
            $iv = mcrypt_create_iv($ivsize);
        }
        $this->iv = $iv;
    }

    public function encrypt($data)
    {
        mcrypt_generic_init($this->module, $this->key, $this->iv);
        $ret = mcrypt_generic($this->module, $data);
        mcrypt_generic_deinit($this->module);
        return $ret;
    }

    public function decrypt($data)
    {
        mcrypt_generic_init($this->module, $this->key, $this->iv);
        $ret = mdecrypt_generic($this->module, $data);
        mcrypt_generic_deinit($this->module);

        for ($i = strlen($ret) - 1; $i >= 0; $i--) {
            if (substr($ret, $i, 1) != "\x0") {
                $ret = substr($ret, 0, $i+1);
                break;
            }
        }
        return $ret;
    }

    public function getBlockSize()
    {
        return mcrypt_get_block_size($this->cipher, $this->mode);
    }
}
