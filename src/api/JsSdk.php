<?php


namespace fize\third\wechat\api;


use fize\third\wechat\Api;


/**
 * JS-SDK
 */
class JsSdk extends Api
{

    /**
     * @var string jsapiTicket缓存名
     */
    private $jsapiTicketCacheKey = "_WEIXIN_JSAPI_TICKET_";

    /**
     * 获取JSAPI授权TICKET
     * @return string|false 失败时返回false
     */
    public function getJsApiTicket()
    {
        $rs = $this->cache->get($this->jsapiTicketCacheKey . $this->appid);
        if ($rs) {
            return $rs;
        }
        $json = $this->httpGet("/ticket/getticket?access_token={$this->accessToken}&type=jsapi");
        if ($json) {
            $expire = $json['expires_in'] ? intval($json['expires_in']) - 100 : 3600;
            $this->cache->set($this->jsapiTicketCacheKey . $this->appid, $json['ticket'], $expire);
            return $json['ticket'];
        } else {
            return false;
        }
    }

    /**
     * 删除JSAPI授权TICKET
     * @return bool
     */
    public function resetJsApiTicket()
    {
        return $this->cache->delete($this->jsapiTicketCacheKey . $this->appid);
    }

    /**
     * 获取签名
     * @param array $arrdata 签名数组
     * @return string 签名值
     */
    private function getSignature($arrdata)
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

    /**
     * 获取JsApi使用签名
     * @param string $url 网页的URL，自动处理#及其后面部分 为空则签名当前页
     * @param int $timestamp 当前时间戳 (为空则自动生成)
     * @param string $noncestr 随机串 (为空则自动生成)
     * @return array|bool 返回签名字串
     */
    public function getJsSign($url = '', $timestamp = 0, $noncestr = '')
    {
        $jsapi_ticket = $this->getJsApiTicket();
        if (!$jsapi_ticket) {
            return false;
        }
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
            $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
            $url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        }
        $arrdata = [
            "timestamp"    => $timestamp,
            "noncestr"     => $noncestr,
            "url"          => $url,
            "jsapi_ticket" => $jsapi_ticket
        ];
        $sign = $this->getSignature($arrdata);
        if (!$sign) {
            return false;
        }
        return [
            "appId"     => $this->appid,
            "nonceStr"  => $noncestr,
            "timestamp" => $timestamp,
            "url"       => $url,
            "signature" => $sign
        ];
    }
}
