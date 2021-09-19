<?php

namespace fize\third\wechat;

/**
 * 开放平台
 */
class Open
{

    /**
     * 域名
     */
    const HOST = 'open.weixin.qq.com';

    /**
     * @var string 唯一凭证
     */
    protected $appid;

    /**
     * @var string APP密钥
     */
    protected $appsecret;

    /**
     * 构造
     * @param string $appid     APPID
     * @param string $appsecret APP密钥
     */
    public function __construct(string $appid, string $appsecret)
    {
        $this->appid = $appid;
        $this->appsecret = $appsecret;
    }
}
