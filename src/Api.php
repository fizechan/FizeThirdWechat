<?php


namespace fize\third\wechat;


use fize\net\Http;
use fize\cache\Cache;
use fize\cache\CacheHandler;
use fize\crypt\Json;


/**
 * 微信底层核心类
 * @package fize\third\wechat
 */
class Api
{

    const PREFIX_API = 'https://api.weixin.qq.com';

    const PREFIX_CGI = 'https://api.weixin.qq.com/cgi-bin';

    const URL_TOKEN = '/token?grant_type=client_credential&';

    const URL_GETCALLBACKIP = '/getcallbackip?';

    const URL_GET_CURRENT_SELFMENU_INFO = '/get_current_selfmenu_info?';

    public $errCode = 0;
    public $errMsg = "";

    protected $debug = false;

    protected $appid;
    protected $appsecret;

    protected $token;

    protected $encrypt_type;
    protected $encodingAesKey;

    protected $access_token;

    private $cacheKey = "_WEIXIN_ACCESS_TOKEN_";

    /**
     * @var Http
     */
    protected $http;

    /**
     * @var CacheHandler
     */
    protected $cache;

    /**
     * 构造函数
     * @param array $options 参数数组
     */
    public function __construct(array $options)
    {
        $this->token = isset($options['token']) ? $options['token'] : '';
        $this->encodingAesKey = isset($options['encodingaeskey']) ? $options['encodingaeskey'] : '';
        $this->appid = isset($options['appid']) ? $options['appid'] : '';
        $this->appsecret = isset($options['appsecret']) ? $options['appsecret'] : '';
        $this->debug = isset($options['debug']) ? $options['debug'] : false;
        if (isset($options['cachekey'])) {
            $this->cacheKey = $options['cachekey'];
        }

        $this->http = new Http();
        $this->cache = Cache::getNew('File');
    }

    /**
     * 核心GET函数
     * @param string $p_url 请求的URL
     * @param bool $p_encode 是否对结果进行JSON编码
     * @param bool $check_token 是否检查当前的TOKEN
     * @return mixed 成功时返回对应结果，失败时返回false
     */
    protected function httpGet($p_url, $p_encode = true, $check_token = false)
    {
        if ($check_token) {
            if (!$this->access_token && !$this->checkAccessToken()) {
                return false;
            }
        }
        $t_rst = $this->http->get($p_url);
        if ($t_rst) {
            if ($p_encode) {
                $t_json = Json::decode($t_rst);
                if (isset($t_json['errcode']) && $t_json['errcode'] != 0) {
                    $this->errCode = $t_json['errcode'];
                    $this->errMsg = $t_json['errmsg'];
                    return false;
                }
                return $t_json;
            } else {
                return $t_rst;
            }
        } else {
            return false;
        }
    }

    /**
     * 核心POST函数
     * @param string $p_url 请求的URL
     * @param mixed $p_param 提交的参数，可以是数组或者字符串，如果需要上传文件必须使用数组
     * @param bool $p_encode 是否对结果进行JSON编码
     * @param bool $check_token 是否检查当前的TOKEN
     * @return mixed 成功时返回对应结果，失败时返回false
     */
    protected function httpPost($p_url, $p_param, $p_encode = true, $check_token = false)
    {
        if ($check_token) {
            if (!$this->access_token && !$this->checkAccessToken()) {
                return false;
            }
        }
        $t_rst = $this->http->post($p_url, $p_param);
        if ($t_rst) {
            if ($p_encode) {
                $t_json = Json::decode($t_rst);
                if (isset($t_json['errcode']) && $t_json['errcode'] != 0) {
                    $this->errCode = $t_json['errcode'];
                    $this->errMsg = $t_json['errmsg'];
                    return false;
                }
                return $t_json;
            } else {
                return $t_rst;
            }
        } else {
            $this->errCode = $this->http->getLastErrCode();
            $this->errMsg = $this->http->getLastErrMsg();
            return false;
        }
    }

    /**
     * 通用AccessToken验证方法
     * @param string $appid
     * @param string $appsecret
     * @param string $token 手动指定access_token，非必要情况不建议用
     * @return bool AccessToken正确返回true，否则返回false
     */
    public function checkAccessToken($appid = '', $appsecret = '', $token = '')
    {
        if (!$appid || !$appsecret) {
            $appid = $this->appid;
            $appsecret = $this->appsecret;
        }
        if ($token) {  //手动指定token，优先使用
            $this->access_token = $token;
            return true;
        }
        $t_cache = $this->cache->get($this->cacheKey);  //获取当前缓存的access_token
        if ($t_cache) {
            $this->access_token = $t_cache;
            return true;
        }
        $json = $this->httpGet(self::PREFIX_CGI . self::URL_TOKEN . 'appid=' . $appid . '&secret=' . $appsecret, true, false);
        if ($json) {
            $this->access_token = $json['access_token'];
            $expire = $json['expires_in'] ? intval($json['expires_in']) - 100 : 3600;
            $this->cache->set($this->cacheKey, $json['access_token'], $expire);  //将access_token缓存
            return true;
        }
        return false;
    }

    /**
     * 删除重置验证数据
     */
    public function resetAccessToken()
    {
        $this->access_token = '';
        $this->cache->remove($this->cacheKey);
    }

    /**
     * 返回当前AccessToken,供测试使用
     * @return string
     */
    public function getAccessToken()
    {
        return $this->access_token;
    }

    /**
     * 判断当前浏览器是否为微信内置浏览器
     * @return boolean
     */
    public static function isWechatBrowser()
    {
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 获取微信服务器IP地址列表
     * @return mixed 成功时返回数组，失败时返回false
     */
    public function getCallBackIp()
    {
        $this->checkAccessToken();
        $json = $this->httpGet(self::PREFIX_CGI . self::URL_GETCALLBACKIP . 'access_token=' . $this->access_token);
        if ($json) {
            return $json['ip_list'];
        }
        return false;
    }

    /**
     * 获取自定义菜单配置接口
     * @return mixed 成功时返回数组，失败时返回false
     */
    public function getCurrentSelfmenuInfo()
    {
        $this->checkAccessToken();
        $json = $this->httpGet(self::PREFIX_CGI . self::URL_GET_CURRENT_SELFMENU_INFO . 'access_token=' . $this->access_token);
        return $json;
    }
}
