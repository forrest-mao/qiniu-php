<?php
// Hack to override the time returned from the S3SignatureV4
namespace Qiniu\Common
{
    function time()
    {
        return isset($_SERVER['override_qiniu_auth_time'])
            ? strtotime('Jan 2, 2006 15:04:05 MST')
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

    public function testDeprecatedPolicy()
    {

    }

}
}
