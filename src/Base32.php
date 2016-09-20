<?php

namespace Fruit\CryptoKit;

class Base32 implements Crypter
{
    const STD = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';
    const DNS = '0123456789ABCDEFGHIJKLMNOPQRSTUV';

    private $charMap;
    private $invertMap;

    public function __construct($str = self::STD)
    {
        if (strlen($str) !== 32) {
            $str = self::STD;
        }

        $this->charMap = $str;
        $this->invertMap = null; // not prepared
    }

    public function encrypt($data)
    {
        return self::doEncrypt($this->charMap, $data);
    }

    public static function E($data)
    {
        return self::doEncrypt(self::STD, $data);
    }

    private static function doEncrypt($map, $data)
    {
        $ret = '';
        for ($l = strlen($data); $l > 5; $l -= 5) {
            $ret .= self::realEncrypt($map, substr($data, 0, 5));
            $data = substr($data, 5);
        }
        if ($l > 0) {
            $ret .= self::realEncrypt($map, $data);
        }
        return $ret;
    }

    private static function realEncrypt($map, $data)
    {
        $arr = array(0, 0, 0, 0, 0, 0, 0, 0);
        $l = strlen($data);
        $pad = '';
        switch ($l) {
            case 5:
                $b = ord($data[4]);
                $arr[7] = $b & 0x1f;
                $arr[6] = $b >> 5;
            case 4:
                $b = ord($data[3]);
                $arr[6] |= ($b << 3) & 0x1f;
                $arr[5] = ($b >> 2) & 0x1f;
                $arr[4] = $b >> 7;
            case 3:
                $b = ord($data[2]);
                $arr[4] |= ($b << 1) & 0x1f;
                $arr[3] = ($b >> 4) & 0x1f;
            case 2:
                $b = ord($data[1]);
                $arr[3] |= ($b << 4) & 0x1f;
                $arr[2] = ($b >> 1) & 0x1f;
                $arr[1] = $b >> 6 & 0x1f;
            default:
                $b = ord($data[0]);
                $arr[1] |= ($b << 2) & 0x1f;
                $arr[0] = $b >> 3;
        }
        switch ($l) {
            case 1:
                $pad .= '=';
            case 2:
                $pad .= '==';
            case 3:
                $pad .= '=';
            case 4:
                $pad .= '==';
        }

        $ret = '';
        for ($i = 0; $i < 8 - strlen($pad); $i++) {
            $ret .= $map[$arr[$i]];
        }
        return $ret . $pad;
    }

    public function decrypt($data)
    {
        // prepare invert map
        if ($this->invertMap === null) {
            $this->invertMap = array();
            for ($k = 0; $k < 32; $k++) {
                $v = $this->charMap[$k];
                $this->invertMap[$v] = $k;
            }
        }

        return self::doDecrypt($this->invertMap, strtoupper($data));
    }

    public static function D($data)
    {
        static $map = array(
            // hard-coded here, make it run faster
            'A' =>  0, 'B' =>  1, 'C' =>  2, 'D' =>  3,
            'E' =>  4, 'F' =>  5, 'G' =>  6, 'H' =>  7,
            'I' =>  8, 'J' =>  9, 'K' => 10, 'L' => 11,
            'M' => 12, 'N' => 13, 'O' => 14, 'P' => 15,
            'Q' => 16, 'R' => 17, 'S' => 18, 'T' => 19,
            'U' => 20, 'V' => 21, 'W' => 22, 'X' => 23,
            'Y' => 24, 'Z' => 25, '2' => 26, '3' => 27,
            '4' => 28, '5' => 29, '6' => 30, '7' => 31,
        );

        return self::doDecrypt($map, strtoupper($data));
    }

    private static function doDecrypt($map, $data)
    {
        $ret = '';
        for ($l = strlen($data); $l > 8; $l -= 8) {
            $ret .= self::realDecrypt($map, substr($data, 0, 8));
            $data = substr($data, 8);
        }
        if ($l > 0) {
            $ret .= self::realDecrypt($map, $data);
        }
        return $ret;
    }

    private static function realDecrypt($map, $data)
    {
        // strip padding
        $data = rtrim($data, '=');
        // data length can not be 1, 3 or 6
        $l = strlen($data);
        if ($l === 1 or $l === 3 or $l === 6) {
            return '';
        }

        $ret = '';
        switch ($l) {
            case 8: // 5 chars
                $c1 = $map[$data[7]];
                $c2 = $map[$data[6]];
                $ret = chr($c1 | ($c2 << 5)) . $ret;
            case 7:
                $c1 = $map[$data[6]];
                $c2 = $map[$data[5]];
                $c3 = $map[$data[4]];
                $ret = chr(($c1 >> 3) | ($c2 << 2) | ($c3 << 7)) . $ret;
            case 5:
                $c1 = $map[$data[4]];
                $c2 = $map[$data[3]];
                $ret = chr(($c1 >> 1) | ($c2 << 4)) . $ret;
            case 4:
                $c1 = $map[$data[3]];
                $c2 = $map[$data[2]];
                $c3 = $map[$data[1]];
                $ret = chr(($c1 >> 4) | ($c2 << 1) | ($c3 << 6)) . $ret;
            default:
                $c1 = $map[$data[1]];
                $c2 = $map[$data[0]];
                $ret = chr(($c1 >> 2) | ($c2 << 3)) . $ret;
        }

        return $ret;
    }

    public function getEncryptBlockSize()
    {
        return 5; // 5 bytes plain text => 8 bytes crypted text
    }
    public function getDecryptBlockSize()
    {
        return 8; // 8 bytes crypted text => 5 bytes plain text
    }
}
