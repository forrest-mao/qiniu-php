<?php
// Hack to override the time returned from the S3SignatureV4
namespace Qiniu\Common
{
    function time()
    {
        return isset($_SERVER['override_qiniu_auth_time'])
            ? 1234567890
            : \time();
    }
}


namespace Qiniu\Tests
{
use Qiniu\Common\Auth;

class AuthTest extends \PHPUnit_Framework_TestCase
{

    public function testToken()
    {
        global $dummyAuth;
        $token = $dummyAuth->token('test');
        $this->assertEquals($token, 'abcdefghklmnopq:mSNBTR7uS2crJsyFr2Amwv1LaYg=');
    }

    public function testTokenWithData()
    {
        global $dummyAuth;
        $token = $dummyAuth->tokenWithData('test');
        $this->assertEquals($token, 'abcdefghklmnopq:-jP8eEV9v48MkYiBGs81aDxl60E=:dGVzdA==');
    }

    public function testTokenOfRequest()
    {
        global $dummyAuth;
        $token = $dummyAuth->tokenOfRequest('http://www.qiniu.com?go=1', 'test', '');
        $this->assertEquals($token, 'abcdefghklmnopq:cFyRVoWrE3IugPIMP5YJFTO-O-Y=');

        $token = $dummyAuth->tokenOfRequest('http://www.qiniu.com?go=1', 'test', 'application/x-www-form-urlencoded');
        $this->assertEquals($token, 'abcdefghklmnopq:svWRNcacOE-YMsc70nuIYdaa1e4=');
    }

    public function testPrivateDownloadUrl()
    {
        global $dummyAuth;
        $_SERVER['override_qiniu_auth_time'] = true;
        $url =  $dummyAuth->privateDownloadUrl('http://www.qiniu.com?go=1');
        $expect = 'http://www.qiniu.com?go=1&e=1234571490&token=abcdefghklmnopq:8vzBeLZ9W3E4kbBLFLW0Xe0u7v4=';
        $this->assertEquals($url, $expect);
    }

    /**
     * @expectedException        InvalidArgumentException
     * @expectedExceptionMessage asyncOps has deprecated
     */
    public function testDeprecatedPolicy()
    {
        global $dummyAuth;
        $token = $dummyAuth->uploadToken('1', null, 3600, array('asyncOps'=> 1));
    }

    public function testUploadToken()
    {

    }

}
}
