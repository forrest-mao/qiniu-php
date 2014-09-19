<?php
namespace Qiniu\Storage;

use Qiniu\Common\Auth;

final class Bucket
{
    private $auth;

    public function __construct(Auth $auth)
    {
        $this->$auth = $auth;
    }
}
