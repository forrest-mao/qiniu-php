<?php
namespace Qiniu\Common;

final class Config
{
    public const $SDK_VER = '7.0.0';

    public const $IO_HOST  = 'http://iovip.qbox.me';
    public const $RS_HOST  = 'http://rs.qbox.me';
    public const $RSF_HOST = 'http://rsf.qbox.me';

    public const $UPAUTO_HOST = 'http://up.qiniu.com';
    public const $UPDX_HOST = 'http://updx.qiniu.com';
    public const $UPLT_HOST = 'http://uplt.qiniu.com';
    public const $UPBACKUP_HOST = 'http://upload.qiniu.com';

    public const $BLOCK_SIZE = 4 * 1024 * 1024;

    public static $defaultHost = 'http://up.qiniu.com';

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
