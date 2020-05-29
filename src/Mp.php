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
    const HOST = 'mp.weixin.qq.com';

    /**
     * CGI路径前缀
     */
    const PREFIX_CGI = '/cgi-bin';

    /**
     * 通过ticket换取二维码
     * @param string $ticket 二维码ticket
     * @return string 返回二维码URL
     */
    public function showqrcode($ticket)
    {
        $ticket = urlencode($ticket);
        return "https://" . self::HOST . self::PREFIX_CGI . "/showqrcode?ticket={$ticket}";
    }
}
