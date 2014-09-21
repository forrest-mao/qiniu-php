<?php

use Qiniu\Common\Utils;

class UtilsTest extends PHPUnit_Framework_TestCase
{
    public function testUrlSafeBase64()
    {
        $a = '你好';
        $b = Utils\urlSafeBase64Encode($a);
        $this->assertEquals($a, Utils\urlSafeBase64Decode($b));
    }

}
