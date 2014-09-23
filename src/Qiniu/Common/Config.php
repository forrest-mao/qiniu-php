<?php
namespace Qiniu\Common;

final class Config
{
    const SDK_VER = '7.0.0';

    const IO_HOST  = 'http://iovip.qbox.me';
    const RS_HOST  = 'http://rs.qbox.me';
    const RSF_HOST = 'http://rsf.qbox.me';

    const UPAUTO_HOST = 'http://up.qiniu.com';
    const UPDX_HOST = 'http://updx.qiniu.com';
    const UPLT_HOST = 'http://uplt.qiniu.com';
    const UPBACKUP_HOST = 'http://upload.qiniu.com';

    const BLOCK_SIZE = 4194304; # 4*1024*1024

    public static $defaultHost = UPBACKUP_HOST;

    public static function userAgent()
    {
        $sdkInfo = "QiniuPHP/" . self::$SDK_VER;

        $systemInfo = php_uname("s");
        $machineInfo = php_uname("m");

        $envInfo = "($systemInfo/$machineInfo)";

        $phpVer = phpversion();

        $ua = "$sdkInfo $envInfo PHP/$phpVer";
        return $ua;
    }
}
