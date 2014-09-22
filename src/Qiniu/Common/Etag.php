<?php

namespace Qiniu\Common;

use Qiniu\Common\Config;

final class Etag
{
    private static function packArray($v, $a)
    {
        return call_user_func_array('pack', array_merge(array($v), (array)$a));
    }

    private static function blockCount($fsize)
    {
        return (($fsize + (Config::BLOCK_SIZE - 1)) / Config::BLOCK_SIZE);
    }

    private static function calcSha1($fhandler)
    {
        $fdata = fread($fhandler, Config::BLOCK_SIZE);
        $sha1Str = sha1($fdata, true);
        $err = error_get_last();
        if ($err != null) {
            return array(null, $err);
        }
        $byteArray = unpack('C*', $sha1Str);
        return array($byteArray, null);
    }


    public static function sum($filename)
    {
        $fhandler = fopen($filename, 'r');
        $err = error_get_last();
        if ($err != null) {
            return array(null, $err);
        }

        $fstat = fstat($fhandler);
        $fsize = $fstat['size'];
        $blockCnt = BlockCount($fsize);
        $sha1Buf = array();

        if ($blockCnt <= 1) {
            $sha1Buf[] = 0x16;
            list($sha1Code, $err) = CalSha1($fhandler);
            if ($err != null) {
                return array(null, $err);
            }
            fclose($fhandler);
            $sha1Buf = array_merge($sha1Buf, $sha1Code);
        } else {
            $sha1Buf[] = 0x96;
            $sha1BlockBuf = array();
            for ($i=0; $i < $blockCnt; $i++) {
                list($sha1Code, $err) = CalSha1($fhandler);
                if ($err != null) {
                    return array(null, $err);
                }
                $sha1BlockBuf = array_merge($sha1BlockBuf, $sha1Code);
            }
            $tmpData = PackArray('C*', $sha1BlockBuf);
            $tmpFhandler = tmpfile();
            fwrite($tmpFhandler, $tmpData);
            fseek($tmpFhandler, 0);
            list($sha1Final, $_err) = CalSha1($tmpFhandler);
            $sha1Buf = array_merge($sha1Buf, $sha1Final);
        }
        $etag = URLSafeBase64Encode(PackArray('C*', $sha1Buf));
        return array($etag, null);
    }
}
