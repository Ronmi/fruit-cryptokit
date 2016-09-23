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
        $len = strlen($data);
        for ($x = 0; $x < $len; $x += 5) {
            $l = $len - $x;
            if ($l > 5) {
                $l = 5;
            }
            $arr = array(0, 0, 0, 0, 0, 0, 0, 0);
            $pad = '';
            switch ($l) {
                case 5:
                    $b = ord($data[$x+4]);
                    $arr[7] = $b & 0x1f;
                    $arr[6] = $b >> 5;
                case 4:
                    $b = ord($data[$x+3]);
                    $arr[6] |= ($b << 3) & 0x1f;
                    $arr[5] = ($b >> 2) & 0x1f;
                    $arr[4] = $b >> 7;
                case 3:
                    $b = ord($data[$x+2]);
                    $arr[4] |= ($b << 1) & 0x1f;
                    $arr[3] = ($b >> 4) & 0x1f;
                case 2:
                    $b = ord($data[$x+1]);
                    $arr[3] |= ($b << 4) & 0x1f;
                    $arr[2] = ($b >> 1) & 0x1f;
                    $arr[1] = $b >> 6 & 0x1f;
                default:
                    $b = ord($data[$x]);
                    $arr[1] |= ($b << 2) & 0x1f;
                    $arr[0] = $b >> 3;
            }
            switch ($l) {
                case 1:
                    $pad .= '==';
                case 2:
                    $pad .= '=';
                case 3:
                    $pad .= '==';
                case 4:
                    $pad .= '=';
            }

            $l = strlen($pad);
            for ($i = 0; $i < 8 - $l; $i++) {
                $ret .= $map[$arr[$i]];
            }
            $ret .= $pad;
        }
        return $ret;
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

        return self::doDecrypt($this->invertMap, $data);
    }

    private static $mapStd = array(
        // hard-coded here, make it run faster in self::D()
        'A' =>  0, 'B' =>  1, 'C' =>  2, 'D' =>  3,
        'E' =>  4, 'F' =>  5, 'G' =>  6, 'H' =>  7,
        'I' =>  8, 'J' =>  9, 'K' => 10, 'L' => 11,
        'M' => 12, 'N' => 13, 'O' => 14, 'P' => 15,
        'Q' => 16, 'R' => 17, 'S' => 18, 'T' => 19,
        'U' => 20, 'V' => 21, 'W' => 22, 'X' => 23,
        'Y' => 24, 'Z' => 25, '2' => 26, '3' => 27,
        '4' => 28, '5' => 29, '6' => 30, '7' => 31,
        // replicate for lowercase
        'a' =>  0, 'b' =>  1, 'c' =>  2, 'd' =>  3,
        'e' =>  4, 'f' =>  5, 'g' =>  6, 'h' =>  7,
        'i' =>  8, 'j' =>  9, 'k' => 10, 'l' => 11,
        'm' => 12, 'n' => 13, 'o' => 14, 'p' => 15,
        'q' => 16, 'r' => 17, 's' => 18, 't' => 19,
        'u' => 20, 'v' => 21, 'w' => 22, 'x' => 23,
        'y' => 24, 'z' => 25,
    );
    public static function D($data)
    {
        return self::doDecrypt(self::$map, $data);
    }

    private static function doDecrypt($map, $data)
    {
        $ret = '';
        $data = rtrim($data, '=');
        $len = strlen($data);
        for ($i = strlen($data); $i > 0; $i -= 8) {
            $l = $i;
            $x = $len - $l;
            if ($l > 8) {
                $l = 8;
            }

            $tmp = '';
            switch ($l) {
                case 1:
                case 3:
                case 6:
                    return '';
                case 8: // 5 chars
                    $c1 = $map[$data[$x+7]];
                    $c2 = $map[$data[$x+6]];
                    $tmp = chr($c1 | ($c2 << 5)) . $tmp;
                case 7:
                    $c1 = $map[$data[$x+6]];
                    $c2 = $map[$data[$x+5]];
                    $c3 = $map[$data[$x+4]];
                    $tmp = chr(($c1 >> 3) | ($c2 << 2) | ($c3 << 7)) . $tmp;
                case 5:
                    $c1 = $map[$data[$x+4]];
                    $c2 = $map[$data[$x+3]];
                    $tmp = chr(($c1 >> 1) | ($c2 << 4)) . $tmp;
                case 4:
                    $c1 = $map[$data[$x+3]];
                    $c2 = $map[$data[$x+2]];
                    $c3 = $map[$data[$x+1]];
                    $tmp = chr(($c1 >> 4) | ($c2 << 1) | ($c3 << 6)) . $tmp;
                default:
                    $c1 = $map[$data[$x+1]];
                    $c2 = $map[$data[$x]];
                    $tmp = chr(($c1 >> 2) | ($c2 << 3)) . $tmp;
            }

            $ret .= $tmp;
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
