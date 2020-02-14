<?php


namespace fize\third\wechat;


class Mp extends Common
{

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
}
