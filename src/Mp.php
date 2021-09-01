<?php

namespace fize\third\wechat;

/**
 * MP接口
 */
class Mp extends MpAbstract
{

    /**
     * 域名
     */
    const HOST_MP = 'mp.weixin.qq.com';

    /**
     * 通过ticket换取二维码
     * @param string $ticket 二维码ticket
     * @return string 返回二维码URL
     */
    public function showqrcode(string $ticket): string
    {
        $ticket = urlencode($ticket);
        return "https://" . self::HOST_MP . self::PREFIX_CGI . "/showqrcode?ticket=$ticket";
    }
}
