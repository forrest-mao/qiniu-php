<?php
namespace Qiniu\Common\Utils;

function urlSafeBase64Encode($data)
{
    $find = array('+', '/');
    $replace = array('-', '_');
    return str_replace($find, $replace, base64_encode($data));
}


function urlSafeBase64Decode($str)
{
    $find = array('-', '_');
    $replace = array('+', '/');
    return base64_decode(str_replace($find, $replace, $str));
}

function etag($file)
{

}

function crc32()
{

}
