<?php


namespace fize\third\wechat;

/**
 * 微信底层
 */
abstract class Common
{
    /**
     * @var int 错误码
     */
    protected $errCode = 0;

    /**
     * @var string 错误描述
     */
    protected $errMsg = "";

    /**
     * 获取最后的错误码
     * @return int
     */
    public function getLastErrCode()
    {
        return $this->errCode;
    }

    /**
     * 获取最后的错误描述
     * @return string
     */
    public function getLastErrMsg()
    {
        return $this->errMsg;
    }

    /**
     * 通过ticket换取二维码
     * @param string $ticket 二维码ticket
     * @return string 返回二维码URL
     */
    public static function showqrcode($ticket)
    {
        $ticket = urlencode($ticket);
        return "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket={$ticket}";
    }

    /**
     * 判断当前浏览器是否为微信内置浏览器
     * @return bool
     */
    public static function isWechatBrowser()
    {
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) {
            return true;
        } else {
            return false;
        }
    }
}
