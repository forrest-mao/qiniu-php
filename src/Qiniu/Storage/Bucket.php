<?php
namespace Qiniu\Storage;

use Qiniu\Common\Auth;
use Qiniu\Common\Config;
use Guzzle\Http\Client;

final class Bucket
{
    private $auth;
    private $bucket;

    public function __construct(Auth $auth, $bucket)
    {
        $this->auth = $auth;
        $this->bucket = $bucket;
    }

    public function buckets()
    {
        $client = new Client(Config::RS_HOST);
        // Create a request with basic Auth
        $request = $client->get('/buckets', $this->auth->authorization(Config::RS_HOST . '/buckets'));
        // Send the request and get the response
        $response = $request->send();
        echo $response->getBody();
        // >>> {"type":"User", ...
        echo $response->getHeader('Content-Length');
        return $response->getBody();
    }
        // def buckets(self):
        // url = 'http://{0}/buckets'.format(config.RS_HOST)
        // r = self.__post(url)
        // return _ret(r)
}
