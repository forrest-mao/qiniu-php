<?php

require_once __DIR__.'/../vendor/autoload.php';

$accessKey = getenv("QINIU_ACCESS_KEY");
$secretKey = getenv("QINIU_SECRET_KEY");

$dummyAccessKey = 'abcdefghklmnopq';
$dummySecretKey = '1234567890';

$tid = getenv("TRAVIS_JOB_NUMBER");

$testEnv = getenv("QINIU_TEST_ENV");

if (!empty($tid)) {
    $pid = getmypid();
    $tid = strstr($tid, ".");
    $tid .= "." . $pid;
}
