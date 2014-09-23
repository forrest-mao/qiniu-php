<?php
namespace Qiniu\Tests;

use Qiniu\Storage\Bucket;

class BucketTest extends \PHPUnit_Framework_TestCase
{
    public function testBuckets()
    {
        global $testAuth;
        global $bucketName;
        $ret = Bucket::buckets($testAuth);
        $this->assertTrue(in_array($bucketName, $ret));
    }
}
