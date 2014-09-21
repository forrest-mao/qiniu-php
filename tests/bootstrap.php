<?php

require __DIR__.'/../vendor/autoload.php';

use Qiniu\Common\Auth;

$accessKey = getenv("QINIU_ACCESS_KEY");
$secretKey = getenv("QINIU_SECRET_KEY");

$dummyAccessKey = 'abcdefghklmnopq';
$dummySecretKey = '1234567890';
$dummyAuth = new Auth(dummyAccessKey, dummySecretKey);

$tid = getenv("TRAVIS_JOB_NUMBER");

$testEnv = getenv("QINIU_TEST_ENV");

if (!empty($tid)) {
	$pid = getmypid();
	$tid = strstr($tid, ".");
	$tid .= "." . $pid;
}

function initKeys() {
}

function getTid() {
	global $tid;
	return $tid;
}

function getTestEnv() {
	global $testEnv;
	return $testEnv;
}

class MockReader
{
	private $off = 0;

	public function __construct($off = 0)
	{
		$this->off = $off;
	}

	public function Read($bytes) // => ($data, $err)
	{
		$off = $this->off;
		$data = '';
		for ($i = 0; $i < $bytes; $i++) {
			$data .= chr(65 + ($off % 26)); // ord('A') = 65
			$off++;
		}
		$this->off = $off;
		return array($data, null);
	}
}
