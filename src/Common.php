<?php


namespace fize\third\wechat;

use fize\crypt\Json;
use fize\net\Http;

/**
 * 微信底层
 */
abstract class Common
{

    /**
     * 核心GET函数
     * @param string $path 请求路径
     * @param bool $response_json_decode 是否对结果进行JSON解码
     * @param bool $check_token 是否检查当前的TOKEN
     * @param string $path_prefix 路径前缀
     * @param string $scheme 协议
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
        $result = Http::get($uri);
        if (!$result) {
            throw new ApiException(Http::getLastErrMsg(), Http::getLastErrCode());
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
     * @param string $path 请求路径
     * @param array|string $params 提交的参数，可以是数组或者字符串，如果需要上传文件必须使用数组
     * @param bool $params_json_encode 是否对参数进行JSON编码
     * @param bool $response_json_decode 是否对结果进行JSON解码
     * @param bool $check_token 是否检查当前的TOKEN
     * @param string $path_prefix 路径前缀
     * @param string $scheme 协议
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
        $result = Http::post($uri, $params);
        if (!$result) {
            throw new ApiException(Http::getLastErrMsg(), Http::getLastErrCode());
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
        $cache = $this->cache->get($this->cacheKey . $this->appid);  //获取当前缓存的access_token
        if ($cache) {
            $this->accessToken = $cache;
            return;
        }
        $json = $this->httpGet("/token?grant_type=client_credential&appid={$this->appid}&secret={$this->appsecret}", true, false);
        $this->accessToken = $json['access_token'];
        $expire = $json['expires_in'] ? intval($json['expires_in']) - 100 : 3600;
        $this->cache->set($this->cacheKey . $this->appid, $json['access_token'], $expire);  //将access_token缓存
    }

    /**
     * 判断当前浏览器是否为微信内置浏览器
     * @return bool
     */
    public static function isWechatBrowser()
    {
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) {
            return true;
        } else {
            return false;
        }
    }
}
