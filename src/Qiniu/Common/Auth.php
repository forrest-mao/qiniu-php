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
        return $this->accessKey . ':' . Utils\urlSafeBase64Encode($hmac);
    }

    public function tokenWithData($data) // => $token
    {
        $data = Utils\urlSafeBase64Encode($data);
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

    public function privateDownloadUrl($baseUrl, $expires = 3600)
    {
        $deadline = time() + $expires;

        $pos = strpos($baseUrl, '?');
        if ($pos !== false) {
            $baseUrl .= '&e=';
        } else {
            $baseUrl .= '?e=';
        }
        $baseUrl .= $deadline;

        $token = $this->token($baseUrl);
        return "$baseUrl&token=$token";
    }

    public function uploadToken(
        $bucket,
        $key = null,
        $expires = 3600,
        $policy = null,
        $strictPolicy = true
    ) { // => token

        $deadline = time() + expires;

        $policy = array('scope' => $this->Scope, 'deadline' => $deadline);
        if (!empty($this->CallbackUrl)) {
            $policy['callbackUrl'] = $this->CallbackUrl;
        }
        if (!empty($this->CallbackBody)) {
            $policy['callbackBody'] = $this->CallbackBody;
        }
        if (!empty($this->ReturnUrl)) {
            $policy['returnUrl'] = $this->ReturnUrl;
        }
        if (!empty($this->ReturnBody)) {
            $policy['returnBody'] = $this->ReturnBody;
        }

        if (!empty($this->EndUser)) {
            $policy['endUser'] = $this->EndUser;
        }
        if (!empty($this->InsertOnly)) {
            $policy['exclusive'] = $this->InsertOnly;
        }
        if (!empty($this->DetectMime)) {
            $policy['detectMime'] = $this->DetectMime;
        }
        if (!empty($this->FsizeLimit)) {
            $policy['fsizeLimit'] = $this->FsizeLimit;
        }
        if (!empty($this->SaveKey)) {
            $policy['saveKey'] = $this->SaveKey;
        }
        if (!empty($this->PersistentOps)) {
            $policy['persistentOps'] = $this->PersistentOps;
        }
        if (!empty($this->PersistentPipeline)) {
            $policy['persistentPipeline'] = $this->PersistentPipeline;
        }
        if (!empty($this->PersistentNotifyUrl)) {
            $policy['persistentNotifyUrl'] = $this->PersistentNotifyUrl;
        }
        if (!empty($this->FopTimeout)) {
            $policy['fopTimeout'] = $this->FopTimeout;
        }
        if (!empty($this->MimeLimit)) {
            $policy['mimeLimit'] = $this->MimeLimit;
        }


        $b = json_encode($policy);
        return Qiniu_SignWithData($mac, $b);
    }
}
