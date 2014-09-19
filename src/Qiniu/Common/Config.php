<?php
namespace Qiniu\Common;

final class Config
{
    public const $SDK_VER = "6.1.9";

    public const $IO_HOST  = 'http://iovip.qbox.me';
    public const $RS_HOST  = 'http://rs.qbox.me';
    public const $RSF_HOST = 'http://rsf.qbox.me';

    public const $UPAUTO_HOST = 'up.qiniu.com'
    public const $UPDX_HOST = 'updx.qiniu.com'
    public const $UPLT_HOST = 'uplt.qiniu.com'
    public const $UPBACKUP_HOST = 'upload.qiniu.com'

    public static $defaultHost = $UPAUTO_HOST

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
?>
