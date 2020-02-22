<?php


namespace fize\third\wechat;


/**
 * 微信接口
 */
class Api extends ApiAbstract
{

    /**
     * 获取token
     * @param string $grant_type 获取类型
     * @return array
     */
    public function token($grant_type)
    {
        return $this->httpGet("/token?grant_type={$grant_type}&appid={$this->appid}&secret={$this->appsecret}", true, false);
    }

    /**
     * 获取微信服务器IP地址列表
     * @return array
     */
    public function getcallbackip()
    {
        $result = $this->httpGet("/getcallbackip?access_token={$this->accessToken}");
        return $result['ip_list'];
    }

    /**
     * 长连接转短链接
     * @param string $long_url 需要转换的长链接
     * @return string
     */
    public function shorturl($long_url)
    {
        $params = [
            'action'   => 'long2short',
            'long_url' => $long_url
        ];
        $result = $this->httpPost("/shorturl?access_token={$this->accessToken}", $params);
        return $result['short_url'];
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
     * APi调用次数进行清零
     */
    public function clearQuota()
    {
        $params = [
            'appid' => $this->appid
        ];
        $this->httpPost("/clear_quota?access_token={$this->accessToken}", $params);
    }

    /**
     * 获取公众号的自动回复规则
     * @return array
     */
    public function getCurrentAutoreplyInfo()
    {
        return $this->httpGet("/get_current_autoreply_info?access_token={$this->accessToken}");
    }
}
