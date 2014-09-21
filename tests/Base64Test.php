<?php

use Qiniu\Common\Base64;

class UtilsTest extends PHPUnit_Framework_TestCase
{
    public function testUrlSafeBase64()
    {
        $a = '你好';
        $b = Base64::urlSafeEncode($a);
        $this->assertEquals($a, Base64::urlSafeDecode($b));
    }
}
