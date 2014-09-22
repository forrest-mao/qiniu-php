<?php
namespace Qiniu\Storage;

use Qiniu\Common\Auth;
use Qiniu\Common\Config;

final class Bucket
{
    private $auth;

    public function __construct(Auth $auth)
    {
        $this->$auth = $auth;
    }

    public function buckets()
    {
        $url = "{Config::$RS_HOST}/buckets"

    }
        // def buckets(self):
        // url = 'http://{0}/buckets'.format(config.RS_HOST)
        // r = self.__post(url)
        // return _ret(r)
}
