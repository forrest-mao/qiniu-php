<?php
namespace Qiniu\Tests;

use Qiniu\Common\Base64;

class Base64Test extends \PHPUnit_Framework_TestCase
{
    public function testUrlSafe()
    {
        $a = '你好';
        $b = Base64::urlSafeEncode($a);
        $this->assertEquals($a, Base64::urlSafeDecode($b));
    }
}
