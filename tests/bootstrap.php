<?php

require_once __DIR__.'/../vendor/autoload.php';

use Qiniu\Common\Auth;

$accessKey = getenv("QINIU_ACCESS_KEY");
$secretKey = getenv("QINIU_SECRET_KEY");
$testAuth = new Auth($accessKey, $secretKey);

$dummyAccessKey = 'abcdefghklmnopq';
$dummySecretKey = '1234567890';
$dummyAuth = new Auth($dummyAccessKey, $dummySecretKey);

$tid = getenv("TRAVIS_JOB_NUMBER");

$testEnv = getenv("QINIU_TEST_ENV");

if (!empty($tid)) {
    $pid = getmypid();
    $tid = strstr($tid, ".");
    $tid .= "." . $pid;
}
