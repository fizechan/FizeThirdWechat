<?php


namespace fize\third\wechat;

use fize\cache\CacheFactory;
use fize\crypt\Json;
use fize\http\ClientSimple;
use fize\http\Response;
use Psr\SimpleCache\CacheInterface;

/**
 * 微信接口基类
 */
abstract class ApiAbstract extends Common
{
    /**
     * 通用域名
     */
    const HOST_API = 'api.weixin.qq.com';

    /**
     * 通用异地容灾域名
     */
    const HOST_API2 = 'api2.weixin.qq.com';

    /**
     * 上海域名
     */
    const HOST_SH_API = 'sh.api.weixin.qq.com';

    /**
     * 深圳域名
     */
    const HOST_SZ_API = 'sz.api.weixin.qq.com';

    /**
     * 香港域名
     */
    const HOST_HK_API = 'hk.api.weixin.qq.com';

    const ACTION_DNS = 'dns';

    const ACTION_PING = 'ping';

    const ACTION_ALL = 'all';

    const CHECK_OPERATOR_CHINANET = 'CHINANET';

    const CHECK_OPERATOR_UNICOM = 'UNICOM';

    const CHECK_OPERATOR_CAP = 'CAP';

    const CHECK_OPERATOR_DEFAULT = 'DEFAULT';

    /**
     * @var string 唯一凭证
     */
    protected $appid;

    /**
     * @var string APP密钥
     */
    protected $appsecret;

    /**
     * @var string 使用的HOST
     */
    protected $host;

    /**
     * @var string 全局唯一接口调用凭据
     */
    protected $accessToken;

    /**
     * @var string TOKEN缓存名
     */
    private $cacheKey = "_WEIXIN_ACCESS_TOKEN_";

    /**
     * @var CacheInterface 缓存
     */
    protected $cache;

    /**
     * @var bool 是否初始化时马上检测AccessToken
     */
    protected $checkAccessToken = true;

    /**
     * 构造
     * @param string              $appid     APPID
     * @param string              $appsecret APP密钥
     * @param CacheInterface|null $cache     指定缓存器
     * @param array               $options   其他配置参数
     */
    public function __construct(string $appid, string $appsecret, CacheInterface $cache = null, array $options = [])
    {
        $this->host = $options['host'] ?? self::HOST_API;

        $this->appid = $appid;
        $this->appsecret = $appsecret;

        if (is_null($cache)) {
            if (isset($options['cache']['key'])) {
                $this->cacheKey = $options['cache']['key'];
            }
            $cache_handler = $options['cache']['handler'] ?? 'file';
            $cache_config = $options['cache']['config'] ?? [];
            $cache = CacheFactory::create($cache_handler, $cache_config);
        }
        $this->cache = $cache;

        if ($this->checkAccessToken) {  // 检测TOKEN以便于URI中的token字段马上有效
            $this->checkAccessToken();
        }
    }

    /**
     * 核心GET函数
     * @param string $path                 请求路径
     * @param bool   $response_json_decode 是否对结果进行JSON解码
     * @param bool   $check_token          是否检查当前的TOKEN
     * @param string $path_prefix          路径前缀
     * @param string $scheme               协议
     * @return array|string 返回JSON解析数组或者原body内容
     */
    protected function httpGet(string $path, bool $response_json_decode = true, bool $check_token = true, string $path_prefix = self::PREFIX_CGI, string $scheme = 'https')
    {
        if ($check_token) {
            if (!$this->accessToken) {
                $this->checkAccessToken();
            }
        }
        $uri = $this->getUri($path, $path_prefix, $scheme);
        $response = ClientSimple::get($uri);
        return $this->handleResponse($response, $response_json_decode);
    }

    /**
     * 核心POST函数
     * @param string       $path                 请求路径
     * @param array|string $params               提交的参数，可以是数组或者字符串，如果需要上传文件必须使用数组
     * @param bool         $params_json_encode   是否对参数进行JSON编码
     * @param bool         $response_json_decode 是否对结果进行JSON解码
     * @param bool         $check_token          是否检查当前的TOKEN
     * @param string       $path_prefix          路径前缀
     * @param string       $scheme               协议
     * @return array|string
     */
    protected function httpPost(string $path, $params, bool $params_json_encode = true, bool $response_json_decode = true, bool $check_token = true, string $path_prefix = self::PREFIX_CGI, string $scheme = 'https')
    {
        if ($check_token) {
            if (!$this->accessToken) {
                $this->checkAccessToken();
            }
        }

        if ($params_json_encode) {
            $params = Json::encode($params, JSON_UNESCAPED_UNICODE);
        }

        $uri = $this->getUri($path, $path_prefix, $scheme);
        $response = ClientSimple::post($uri, $params);
        return $this->handleResponse($response, $response_json_decode);
    }

    /**
     * 验证AccessToken
     */
    protected function checkAccessToken()
    {
        $cache = $this->cache->get($this->cacheKey . $this->appid);
        if ($cache) {
            $this->accessToken = $cache;
            return;
        }
        $json = $this->httpGet("/token?grant_type=client_credential&appid={$this->appid}&secret={$this->appsecret}", true, false);
        $this->accessToken = $json['access_token'];
        $expire = $json['expires_in'] ? intval($json['expires_in']) - 100 : 3600;
        $this->cache->set($this->cacheKey . $this->appid, $json['access_token'], $expire);
    }

    /**
     * 补齐完整URI
     * @param string $path   路径
     * @param string $prefix 路径前缀
     * @param string $scheme 协议
     * @return string
     */
    protected function getUri(string $path, string $prefix, string $scheme): string
    {
        return $scheme . '://' . $this->host . $prefix . $path;
    }

    /**
     * 统一处理响应
     * @param Response $response             响应对象
     * @param bool     $response_json_decode 是否对结果进行JSON解码
     * @return array|string
     */
    protected function handleResponse(Response $response, bool $response_json_decode = true)
    {
        if ($response->getStatusCode() != 200) {
            throw new ApiException($response->getReasonPhrase(), $response->getStatusCode());
        }
        $content = $response->getBody()->getContents();
        if ($response_json_decode) {
            $json = Json::decode($content);
            if (isset($json['errcode']) && $json['errcode'] != 0) {
                throw new ApiException($json['errmsg'], $json['errcode']);
            }
            return $json;
        } else {
            return $content;
        }
    }
}
