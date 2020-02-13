<?php


namespace fize\third\wechat;


use fize\cache\Cache;
use fize\cache\CacheInterface;
use fize\crypt\Json;
use fize\net\Http;

/**
 * 公众号
 */
class Offiaccount extends Common
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
     * @var bool 是否DEBUG
     */
    protected $debug = false;

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
     * @todo 待删除
     * @var string
     */
    protected $token;

    protected $encrypt_type;

    protected $encodingAesKey;

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
     * 构造
     * @param array $options 配置参数
     */
    public function __construct(array $options)
    {
        $this->host = isset($options['host']) ? $options['host'] : self::HOST1;

        $this->token = isset($options['token']) ? $options['token'] : '';
        $this->encodingAesKey = isset($options['encodingaeskey']) ? $options['encodingaeskey'] : '';
        $this->appid = isset($options['appid']) ? $options['appid'] : '';
        $this->appsecret = isset($options['appsecret']) ? $options['appsecret'] : '';
        $this->debug = isset($options['debug']) ? $options['debug'] : false;

        if (isset($options['cache']['key'])) {
            $this->cacheKey = $options['cache']['key'];
        }
        $cache_handler = isset($options['cache']['handler']) ? $options['cache']['handler'] : 'file';
        $cache_config = isset($options['cache']['config']) ? $options['cache']['config'] : [];
        $this->cache = Cache::getInstance($cache_handler, $cache_config);

        $this->checkAccessToken();  // 检测TOKEN以便于URI中的token字段马上有效
    }

    /**
     * 核心GET函数
     * @param string $path 请求路径
     * @param bool $response_json_decode 是否对结果进行JSON解码
     * @param bool $check_token 是否检查当前的TOKEN
     * @param string $path_prefix 路径前缀
     * @param string $scheme 协议
     * @return mixed|false 成功时返回对应结果，失败时返回false
     */
    protected function httpGet($path, $response_json_decode = true, $check_token = true, $path_prefix = self::PREFIX_CGI, $scheme = 'https')
    {
        if ($check_token) {
            if (!$this->accessToken && !$this->checkAccessToken()) {
                return false;
            }
        }
        $uri = $this->getUri($path, $path_prefix, $scheme);
        $result = Http::get($uri);
        if (!$result) {
            $this->errCode = Http::getLastErrCode();
            $this->errMsg = Http::getLastErrMsg();
            return false;
        }

        if ($response_json_decode) {
            $json = Json::decode($result);
            if (isset($json['errcode']) && $json['errcode'] != 0) {
                $this->errCode = $json['errcode'];
                $this->errMsg = $json['errmsg'];
                return false;
            }
            return $json;
        } else {
            return $result;
        }
    }

    /**
     * 核心POST函数
     * @param string $path 请求路径
     * @param array|string $params 提交的参数，可以是数组或者字符串，如果需要上传文件必须使用数组
     * @param bool $params_json_encode 是否对参数进行JSON编码
     * @param bool $response_json_decode 是否对结果进行JSON解码
     * @param bool $check_token 是否检查当前的TOKEN
     * @param string $path_prefix 路径前缀
     * @param string $scheme 协议
     * @return mixed|false 成功时返回对应结果，失败时返回false
     */
    protected function httpPost($path, $params, $params_json_encode = true, $response_json_decode = true, $check_token = true, $path_prefix = self::PREFIX_CGI, $scheme = 'https')
    {
        if ($check_token) {
            if (!$this->accessToken && !$this->checkAccessToken()) {
                return false;
            }
        }
        $uri = $this->getUri($path, $path_prefix, $scheme);
        if ($params_json_encode) {
            $params = Json::encode($params, JSON_UNESCAPED_UNICODE);
        }
        $result = Http::post($uri, $params);
        if (!$result) {
            $this->errCode = Http::getLastErrCode();
            $this->errMsg = Http::getLastErrMsg();
            return false;
        }

        if ($response_json_decode) {
            $json = Json::decode($result);
            if (isset($json['errcode']) && $json['errcode'] != 0) {
                $this->errCode = $json['errcode'];
                $this->errMsg = $json['errmsg'];
                return false;
            }
            return $json;
        } else {
            return $result;
        }
    }

    /**
     * 通用AccessToken验证方法
     * @return bool AccessToken正确返回true，否则返回false
     */
    public function checkAccessToken()
    {
        $appid = $this->appid;
        $appsecret = $this->appsecret;

        $cache = $this->cache->get($this->cacheKey . $appid);  //获取当前缓存的access_token
        if ($cache) {
            $this->accessToken = $cache;
            return true;
        }
        $json = $this->httpGet("/token?grant_type=client_credential&appid={$appid}&secret={$appsecret}", true, false);
        if (!$json) {
            return false;
        }
        $this->accessToken = $json['access_token'];
        $expire = $json['expires_in'] ? intval($json['expires_in']) - 100 : 3600;
        $this->cache->set($this->cacheKey . $appid, $json['access_token'], $expire);  //将access_token缓存
        return true;
    }

    /**
     * 删除重置验证数据
     */
    public function resetAccessToken()
    {
        $this->accessToken = '';
        $this->cache->delete($this->cacheKey . $this->appid);
    }

    /**
     * 获取微信服务器IP地址列表
     * @return array|false 成功时返回数组，失败时返回false
     */
    public function getcallbackip()
    {
        $json = $this->httpGet("/getcallbackip?access_token={$this->accessToken}");
        if (!$json) {
            return false;
        }
        return $json['ip_list'];
    }

    /**
     * 长连接转短链接
     * @param string $long_url 需要转换的长链接
     * @param string $action 动作
     * @return bool|mixed
     */
    public function shorturl($long_url, $action = 'long2short')
    {
        $params = [
            'action'   => $action,
            'long_url' => $long_url
        ];
        return $this->httpPost("/shorturl?access_token={$this->accessToken}", $params);
    }

    /**
     * 查询自定义菜单
     * @return array
     */
    public function getCurrentSelfmenuInfo()
    {
        return $this->httpGet("/get_current_selfmenu_info?access_token={$this->accessToken}");
    }

    /**
     * 获取公众号的自动回复规则
     * @return array
     */
    public function getCurrentAutoreplyInfo()
    {
        return $this->httpGet("/get_current_autoreply_info?access_token={$this->accessToken}");
    }

    /**
     * 补齐完整URI
     * @param string $path 路径
     * @param string $prefix 路径前缀
     * @param string $scheme 协议
     * @return string
     */
    protected function getUri($path, $prefix, $scheme)
    {
        return $scheme . '://' . $this->host . $prefix . $path;
    }
}
