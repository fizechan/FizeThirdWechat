<?php

namespace Fize\Third\Wechat;

/**
 * MP基类
 */
abstract class MpAbstract
{
    /**
     * 域名
     */
    const HOST_MP = 'mp.weixin.qq.com';

    /**
     * @var string 协议
     */
    protected $scheme = 'https';

    /**
     * @var string 唯一凭证
     */
    protected $appid;

    /**
     * 构造
     * @param string $appid APPID
     */
    public function __construct(string $appid)
    {
        $this->appid = $appid;
    }

    /**
     * 补齐完整URI
     * @param string      $path   路径
     * @param string|null $scheme 协议
     * @return string
     */
    protected function getUri(string $path, string $scheme = null): string
    {
        $scheme = is_null($scheme) ? $this->scheme : $scheme;
        return $scheme . '://' . self::HOST_MP . $path;
    }
}
