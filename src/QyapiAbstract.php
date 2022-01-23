<?php

namespace Fize\Third\Wechat;

use Fize\Cache\CacheFactory;
use Fize\Crypt\Json;
use Fize\Exception\ThirdException;
use Fize\Http\ClientSimple;
use Psr\Http\Message\ResponseInterface;
use Psr\SimpleCache\CacheInterface;

/**
 * 企业微信接口基类
 */
class QyapiAbstract
{

    /**
     * 通用域名
     */
    const HOST = 'qyapi.weixin.qq.com';

    /**
     * @var string 企业ID
     */
    protected $corpid;

    /**
     * @var string 密钥
     */
    protected $corpsecret;

    /**
     * @var string 使用的HOST
     */
    protected $host;

    /**
     * @var string 缓存键名前缀
     */
    protected $cacheKeyPre;

    /**
     * @var CacheInterface 缓存
     */
    protected $cache;

    /**
     * @var string access_token缓存键名
     */
    protected $accessTokenCacheKey;

    /**
     * @var string 全局唯一接口调用凭据
     */
    protected $accessToken;

    /**
     * @var bool 是否初始化时马上检测AccessToken
     */
    protected $checkAccessToken = true;

    /**
     * @var string URI路径前缀
     */
    protected $pathPrefix = '/cgi-bin';

    /**
     * @var string 协议
     */
    protected $scheme = 'https';

    /**
     * 构造
     * @param string              $corpid     企业ID
     * @param string              $corpsecret 密钥
     * @param array               $options   其他配置参数
     * @param CacheInterface|null $cache     指定缓存器
     */
    public function __construct(string $corpid, string $corpsecret, array $options = [], CacheInterface $cache = null)
    {
        $def_options = [
            'host'        => self::HOST,
            'cachekeyPre' => '_QY_WECHAT_',
            'debug'       => false,
            'cache'       => [
                'handler' => 'file',
                'config'  => []
            ]
        ];
        $options = array_merge($def_options, $options);

        $this->corpid = $corpid;
        $this->corpsecret = $corpsecret;

        $this->host = $options['host'];
        $this->cacheKeyPre = $options['cachekeyPre'];

        if (is_null($cache)) {
            $cache_handler = $options['cache']['handler'];
            $cache_config = $options['cache']['config'] ?? [];
            $cache = CacheFactory::create($cache_handler, $cache_config);
        }
        $this->cache = $cache;
        $this->accessTokenCacheKey = $this->cacheKeyPre . '_ACCESS_TOKEN_' . $this->corpid;

        if ($this->checkAccessToken) {  // 检测TOKEN以便于URI中的token字段马上有效
            $this->getAccessToken();
        }
    }

    /**
     * 获取AccessToken
     * @return string
     */
    protected function getAccessToken(): string
    {
        $accessTokenCache = $this->cache->get($this->accessTokenCacheKey);
        if ($accessTokenCache) {
            $this->accessToken = $accessTokenCache;
            return $this->accessToken;
        }
        $json = $this->httpGet("/gettoken?corpid=$this->corpid&corpsecret=$this->corpsecret", true, false);
        $this->accessToken = $json['access_token'];
        $expire = $json['expires_in'] ? intval($json['expires_in']) - 100 : 3600;
        $this->cache->set($this->accessTokenCacheKey, $json['access_token'], $expire);
        return $this->accessToken;
    }

    /**
     * 核心GET函数
     * @param string      $path              请求路径
     * @param bool        $contentJsonDecode 是否对结果进行JSON解码
     * @param bool        $checkAccessToken  是否检查当前的TOKEN
     * @param string|null $pathPrefix        路径前缀
     * @param string|null $scheme            协议
     * @return array|string 返回JSON解析数组或者原body内容
     */
    protected function httpGet(string $path, bool $contentJsonDecode = true, bool $checkAccessToken = true, string $pathPrefix = null, string $scheme = null)
    {
        if ($checkAccessToken) {
            if (!$this->accessToken) {
                $this->getAccessToken();
            }
        }
        $uri = $this->getUri($path, $pathPrefix, $scheme);
        $response = ClientSimple::get($uri);
        return $this->handleResponse($response, $contentJsonDecode);
    }

    /**
     * 补齐完整URI
     * @param string      $path       路径
     * @param string|null $pathPrefix 路径前缀
     * @param string|null $scheme     协议
     * @return string
     */
    protected function getUri(string $path, string $pathPrefix = null, string $scheme = null): string
    {
        $pathPrefix = is_null($pathPrefix) ? $this->pathPrefix : $pathPrefix;
        $scheme = is_null($scheme) ? $this->scheme : $scheme;
        return $scheme . '://' . $this->host . $pathPrefix . $path;
    }

    /**
     * 统一处理响应
     * @param ResponseInterface $response   响应对象
     * @param bool              $jsonDecode 是否对结果进行JSON解码
     * @return array|string
     */
    protected function handleResponse(ResponseInterface $response, bool $jsonDecode = true)
    {
        if ($response->getStatusCode() != 200) {
            throw new ThirdException('QyWechat', $response->getReasonPhrase(), $response->getStatusCode());
        }
        $content = $response->getBody()->getContents();
        if ($jsonDecode) {
            $json = Json::decode($content);
            if (isset($json['errcode']) && $json['errcode'] != 0) {
                if ($json['errcode'] == 40014) {  // access_token参数错误
                    $this->cache->delete($this->accessTokenCacheKey);
                }
                throw new ThirdException('QyWechat', $json['errmsg'], $json['errcode']);
            }
            return $json;
        } else {
            return $content;
        }
    }

}