<?php


namespace fize\third\wechat;

/**
 * 开放平台
 */
class Open extends Common
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
     * @param array $options 配置参数
     */
    public function __construct(array $options)
    {
        $this->appid = $options['appid'] ;
        $this->appsecret = $options['appsecret'];
    }
}
