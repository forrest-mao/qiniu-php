<?php
namespace Qiniu\Common;

use Qiniu\Common\Utils;

final class Auth
{
    private $accessKey;
    private $secretKey;

    public function __construct($accessKey, $secretKey)
    {
        $this->accessKey = $accessKey;
        $this->secretKey = $secretKey;
    }

    public function token($data) // => $token
    {
        $hmac = hash_hmac('sha1', $data, $this->secretKey, true);
        return $this->accessKey . ':' . Utils.urlSafeBase64Encode($hmac);
    }

    public function tokenWithData($data) // => $token
    {
        $data = Utils.urlSafeBase64Encode($data);
        return $this->token($data) . ':' . $data;
    }

    public function tokenOfRequest($req, $incbody) // => ($token, $error)
    {
        $url = $req->URL;
        $url = parse_url($url['path']);
        $data = '';
        if (isset($url['path'])) {
            $data = $url['path'];
        }
        if (isset($url['query'])) {
            $data .= '?' . $url['query'];
        }
        $data .= "\n";

        if ($incbody) {
            $data .= $req->Body;
        }
        return $this->token($data);
    }

    public function verifyCallback($auth, $url, $body) // ==> bool
    {
        $url = parse_url($url);
        $data = '';
        if (isset($url['path'])) {
            $data = $url['path'];
        }
        if (isset($url['query'])) {
            $data .= '?' . $url['query'];
        }
        $data .= "\n";

        $data .= $body;
        $token = 'QBox ' . $this->Sign($data);
        return $auth === $token;
    }
}
?>
