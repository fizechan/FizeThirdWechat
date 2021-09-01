<?php

namespace fize\third\wechat;

/**
 * 微信底层
 */
abstract class Common
{

    /**
     * CGI路径前缀
     */
    const PREFIX_CGI = '/cgi-bin';

    /**
     * 判断当前浏览器是否为微信内置浏览器
     * @return bool
     */
    public static function isWechatBrowser(): bool
    {
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) {
            return true;
        } else {
            return false;
        }
    }
}
