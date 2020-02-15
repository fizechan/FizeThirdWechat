<?php


namespace fize\third\wechat\api;


/**
 * JS-SDK
 */
class Jssdk extends Ticket
{

    /**
     * @var string jsapiTicket缓存名
     */
    private $jsapiTicketCacheKey = "_WEIXIN_JSAPI_TICKET_";

    /**
     * 获取JSAPI授权TICKET
     * @return string
     */
    private function getJsApiTicket()
    {
        $cache = $this->cache->get($this->jsapiTicketCacheKey . $this->appid);
        if ($cache) {
            return $cache;
        }
        $result = $this->getticket('jsapi');
        $expire = $result['expires_in'] ? intval($result['expires_in']) - 100 : 3600;
        $this->cache->set($this->jsapiTicketCacheKey . $this->appid, $result['ticket'], $expire);
        return $result['ticket'];
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
     * 获取JsApi权限验证配置
     * @param string $url 网页的URL，自动处理#及其后面部分 为空则签名当前页
     * @param int $timestamp 当前时间戳 (为空则自动生成)
     * @param string $noncestr 随机串 (为空则自动生成)
     * @return array|bool 返回签名字串
     */
    public function getConfig($url = '', $timestamp = 0, $noncestr = '')
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
        return [
            "appId"     => $this->appid,
            "nonceStr"  => $noncestr,
            "timestamp" => $timestamp,
            "url"       => $url,
            "signature" => $sign
        ];
    }
}
