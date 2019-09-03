<?php


namespace fize\third\wechat\api;


use fize\third\wechat\Api;
use fize\third\wechat\Prpcrypt;


/**
 * 微信JSSDK类
 */
class JsSdk extends Api
{

    const URL_GET_TICKET = '/ticket/getticket?';

    private $jsapi_ticket = '';

    /**
     * 构造函数
     * @param array $p_options 参数数组
     */
    public function __construct(array $p_options)
    {
        parent::__construct($p_options);
    }

    /**
     * 获取JSAPI授权TICKET
     * @param string $appid 用于多个appid时使用,可空
     * @param string $jsapi_ticket 手动指定jsapi_ticket，非必要情况不建议用
     * @return mixed
     */
    public function getJsApiTicket($appid = '', $jsapi_ticket = '')
    {
        $this->checkAccessToken();
        if (!$appid) $appid = $this->appid;
        if ($jsapi_ticket) {
            //手动指定token，优先使用
            $this->jsapi_ticket = $jsapi_ticket;
            return $this->jsapi_ticket;
        }
        $authname = 'wechat_jsapi_ticket' . $appid;
        $rs = $this->cache->get($authname);
        if ($rs) {
            $this->jsapi_ticket = $rs;
            return $rs;
        }
        $json = $this->httpGet(self::PREFIX_CGI . self::URL_GET_TICKET . 'access_token=' . $this->access_token . '&type=jsapi');
        if ($json) {
            $this->jsapi_ticket = $json['ticket'];
            $expire = $json['expires_in'] ? intval($json['expires_in']) - 100 : 3600;
            $this->cache->set($authname, $this->jsapi_ticket, $expire);
            return $this->jsapi_ticket;
        } else {
            return false;
        }
    }

    /**
     * 删除JSAPI授权TICKET
     * @param string $appid 用于多个appid时使用
     * @return bool
     */
    public function resetJsApiTicket($appid = '')
    {
        if (!$appid) {
            $appid = $this->appid;
        }
        $this->jsapi_ticket = '';
        $authname = 'wechat_jsapi_ticket' . $appid;
        $this->cache->remove($authname);
        return true;
    }

    /**
     * 获取签名
     * @param array $arrdata 签名数组
     * @param string $method 签名方法
     * @return boolean|string 签名值
     */
    private function getSignature($arrdata, $method = "sha1")
    {
        if (!function_exists($method)) {
            return false;
        }
        ksort($arrdata);
        $paramstring = "";
        foreach ($arrdata as $key => $value) {
            if (strlen($paramstring) == 0) {
                $paramstring .= $key . "=" . $value;
            } else {
                $paramstring .= "&" . $key . "=" . $value;
            }
        }
        $Sign = $method($paramstring);
        return $Sign;
    }

    /**
     * 获取JsApi使用签名
     * @param string $url 网页的URL，自动处理#及其后面部分 为空则签名当前页
     * @param int $timestamp 当前时间戳 (为空则自动生成)
     * @param string $noncestr 随机串 (为空则自动生成)
     * @param string $appid 用于多个appid时使用,可空
     * @return array|bool 返回签名字串
     */
    public function getJsSign($url = '', $timestamp = 0, $noncestr = '', $appid = '')
    {
        if (!$this->jsapi_ticket && !$this->getJsApiTicket($appid)) {
            return false;
        }
        if (!$timestamp) {
            $timestamp = time();
        }
        if (!$noncestr) {
            $noncestr = Prpcrypt::getRandomStr();
        }
        $ret = strpos($url, '#');
        if ($ret) {
            $url = substr($url, 0, $ret);
        }
        $url = trim($url);
        if (empty($url)) {
            $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
            $url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        }
        $arrdata = array("timestamp" => $timestamp, "noncestr" => $noncestr, "url" => $url, "jsapi_ticket" => $this->jsapi_ticket);
        $sign = $this->getSignature($arrdata);
        if (!$sign) {
            return false;
        }
        $signPackage = array(
            "appId"     => $this->appid,
            "nonceStr"  => $noncestr,
            "timestamp" => $timestamp,
            "url"       => $url,
            "signature" => $sign
        );
        return $signPackage;
    }
}