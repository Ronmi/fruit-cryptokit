<?php

namespace Fruit\CryptoKit;

/**
 * Stream filter using Crypter interface to encrypt/decrypt the stream.
 *
 * It needs two parameters:
 * - crypter: an instance of Crypter.
 * - crypt_type: string, 'encrypt' or 'decrypt', case-insensitive.
 */
class CryptoFilter extends \php_user_filter
{
    protected $crypter;
    protected $type;

    protected $buffer;
    // open a temp stream so we can use stream_bucket_new when closing
    protected $temp;

    public function filter($in, $out, &$consumed, $closing)
    {
        $type = $this->type;
        $ret = PSFS_FEED_ME;
        while ($bucket = stream_bucket_make_writeable($in)) {
            $consumed += $bucket->datalen;
            $this->buffer .= $bucket->data;
        }

        $blockSize = $this->crypter->getBlockSize();
        if ($blockSize < 1) {
            // stream cipher or special cases, encrypt every bucket
            $blockSize = 1;
        }
        $len = strlen($this->buffer);
        // process filled blocks
        if ($blockSize > 0 and $len >= $blockSize) {
            $mod = $len % $blockSize;
            $data = $this->crypter->$type(substr($this->buffer, 0, $len - $mod));
            $this->buffer = substr($this->buffer, $len - $mod);

            $bucket = stream_bucket_new($this->temp, $data);
            if ($bucket === false) {
                return PSFS_ERR_FATAL;
            }
            stream_bucket_append($out, $bucket);
            $ret = PSFS_PASS_ON;
        }

        // process rest data if we are closing
        if ($closing and strlen($this->buffer) > 0) {
            $bucket = stream_bucket_new($this->temp, $this->crypter->$type($this->buffer));
            if ($bucket === false) {
                return PSFS_ERR_FATAL;
            }
            $this->buffer = '';
            stream_bucket_append($out, $bucket);
            $ret = PSFS_PASS_ON;
        }

        return $ret;
    }

    public function onCreate()
    {
        // get crypter instance from parameter
        if (!isset($this->params['crypter'])) {
            return false;
        }
        $this->crypter = $this->params['crypter'];
        if (!($this->crypter instanceof Crypter)) {
            return false;
        }

        // get type
        if (!isset($this->params['crypt_type'])) {
            return false;
        }
        $this->type = strtolower($this->params['crypt_type']);
        if ($this->type != 'encrypt' and $this->type != 'decrypt') {
            return false;
        }

        $this->buffer = '';
        $this->temp = @fopen('php://memory', 'w+');

        return is_resource($this->temp);
    }

    public function onClose()
    {
        @fclose($this->temp);
    }
}
