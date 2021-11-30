<?php

namespace Fize\Third\Wechat;

use Fize\Third\Wechat\Api\Ticket;
use Psr\SimpleCache\CacheInterface;

/**
 * JS-SDK
 *
 * 本接口非微信直接提供
 */
class JsSdk extends ApiAbstract
{

    /**
     * @var bool 是否初始化时马上检测AccessToken
     */
    protected $checkAccessToken = false;

    /**
     * @var Ticket 临时票据
     */
    private $ticket;

    /**
     * 构造
     * @param string              $appid     APPID
     * @param string              $appsecret APP密钥
     * @param array               $options   其他配置参数
     * @param CacheInterface|null $cache     指定缓存器
     */
    public function __construct(string $appid, string $appsecret, array $options = [], CacheInterface $cache = null)
    {
        parent::__construct($appid, $appsecret, $options, $cache);
        $this->ticket = new Ticket($appid, $appsecret, $options, $cache);
    }

    /**
     * 获取JsApi权限验证配置
     * @param string $url       网页的URL，自动处理#及其后面部分 为空则签名当前页
     * @param int    $timestamp 当前时间戳 (为空则自动生成)
     * @param string $noncestr  随机串 (为空则自动生成)
     * @return array
     */
    public function getConfig(string $url = '', int $timestamp = 0, string $noncestr = ''): array
    {
        $jsapi_ticket = $this->getJsApiTicket();
        if (!$timestamp) {
            $timestamp = time();
        }
        if (!$noncestr) {
            $noncestr = uniqid();
        }
        $ret = strpos($url, '#');
        if ($ret) {
            $url = substr($url, 0, $ret);
        }
        $url = trim($url);
        if (empty($url)) {
            $protocol = 'http://';
            if ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443)) {
                $protocol = 'https://';
            }
            $host = $_SERVER['HTTP_HOST'] ?? '';
            $uri = $_SERVER['REQUEST_URI'] ?? '';
            $url = $protocol . $host . $uri;
        }
        $arrdata = [
            "timestamp"    => $timestamp,
            "noncestr"     => $noncestr,
            "url"          => $url,
            "jsapi_ticket" => $jsapi_ticket
        ];
        $sign = $this->getSignature($arrdata);
        return [
            "appId"     => $this->appid,
            "nonceStr"  => $noncestr,
            "timestamp" => $timestamp,
            "url"       => $url,
            "signature" => $sign
        ];
    }

    /**
     * 判断当前浏览器是否为微信内置浏览器
     * @return bool
     */
    public static function isWechatBrowser(): bool
    {
        if (!isset($_SERVER['HTTP_USER_AGENT'])) {
            return false;
        } elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 获取JSAPI授权TICKET
     * @return string
     */
    private function getJsApiTicket(): string
    {
        $cacheKey = $this->cacheKeyPre . '_JSAPI_TICKET_' . $this->appid;
        $jsapiTicketCache = $this->cache->get($cacheKey);
        if ($jsapiTicketCache) {
            return $jsapiTicketCache;
        }

        $result = $this->ticket->getticket(Ticket::TICKET_TYPE_JSAPI);
        $expire = $result['expires_in'] ? intval($result['expires_in']) - 100 : 3600;
        $this->cache->set($cacheKey, $result['ticket'], $expire);
        return $result['ticket'];
    }

    /**
     * 获取签名
     * @param array $arrdata 签名数组
     * @return string 签名值
     */
    private function getSignature(array $arrdata): string
    {
        ksort($arrdata);
        $paramstring = "";
        foreach ($arrdata as $key => $value) {
            if (strlen($paramstring) == 0) {
                $paramstring .= $key . "=" . $value;
            } else {
                $paramstring .= "&" . $key . "=" . $value;
            }
        }
        return sha1($paramstring);
    }
}
