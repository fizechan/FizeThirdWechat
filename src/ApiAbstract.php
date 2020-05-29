<?php


namespace fize\third\wechat;

use fize\cache\CacheFactory;
use fize\cache\CacheInterface;
use fize\crypt\Json;
use fize\http\Response;
use fize\http\ResponseException;
use fize\net\Http;

/**
 * 微信接口基类
 */
abstract class ApiAbstract extends Common
{
    /**
     * 通用域名
     */
    const HOST1 = 'api.weixin.qq.com';

    /**
     * 通用异地容灾域名
     */
    const HOST2 = 'api2.weixin.qq.com';

    /**
     * 上海域名
     */
    const HOST3 = 'sh.api.weixin.qq.com';

    /**
     * 深圳域名
     */
    const HOST4 = 'sz.api.weixin.qq.com';

    /**
     * 香港域名
     */
    const HOST5 = 'hk.api.weixin.qq.com';

    /**
     * CGI路径前缀
     */
    const PREFIX_CGI = '/cgi-bin';

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
     * @var Response 响应体
     */
    protected $response;

    /**
     * @var bool 是否初始化时马上检测AccessToken
     */
    protected $checkAccessToken = true;

    /**
     * 构造
     * @param array $options 配置参数
     */
    public function __construct(array $options)
    {
        $this->host = isset($options['host']) ? $options['host'] : self::HOST1;

        $this->appid = $options['appid'];
        $this->appsecret = $options['appsecret'];

        if (isset($options['cache']['key'])) {
            $this->cacheKey = $options['cache']['key'];
        }
        $cache_handler = isset($options['cache']['handler']) ? $options['cache']['handler'] : 'file';
        $cache_config = isset($options['cache']['config']) ? $options['cache']['config'] : [];
        $this->cache = CacheFactory::create($cache_handler, $cache_config);

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
     * @return array|string
     */
    protected function httpGet($path, $response_json_decode = true, $check_token = true, $path_prefix = self::PREFIX_CGI, $scheme = 'https')
    {
        if ($check_token) {
            if (!$this->accessToken) {
                $this->checkAccessToken();
            }
        }
        $uri = $this->getUri($path, $path_prefix, $scheme);
        $this->response = Http::get($uri);
        $result = $this->response->getBody();
        if (empty($result)) {
            throw new ResponseException($this->response);
        }

        if ($response_json_decode) {
            $json = Json::decode($result);
            if (isset($json['errcode']) && $json['errcode'] != 0) {
                throw new ApiException($json['errmsg'], $json['errcode']);
            }
            return $json;
        } else {
            return $result;
        }
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
    protected function httpPost($path, $params, $params_json_encode = true, $response_json_decode = true, $check_token = true, $path_prefix = self::PREFIX_CGI, $scheme = 'https')
    {
        if ($check_token) {
            if (!$this->accessToken) {
                $this->checkAccessToken();
            }
        }
        $uri = $this->getUri($path, $path_prefix, $scheme);
        if ($params_json_encode) {
            $params = Json::encode($params, JSON_UNESCAPED_UNICODE);
        }
        $this->response = Http::post($uri, $params);
        $result = (string)$this->response->getBody();
        if (!$result) {
            throw new ResponseException($this->response);
        }

        if ($response_json_decode) {
            $json = Json::decode($result);
            if (isset($json['errcode']) && $json['errcode'] != 0) {
                throw new ApiException($json['errmsg'], $json['errcode']);
            }
            return $json;
        } else {
            return $result;
        }
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
    protected function getUri($path, $prefix, $scheme)
    {
        return $scheme . '://' . $this->host . $prefix . $path;
    }
}
