<?php

namespace Fize\Third\Wechat;

/**
 * 微信接口
 */
class Api extends ApiAbstract
{

    /**
     * @var bool 是否初始化时马上检测AccessToken
     */
    protected $checkAccessToken = false;

    /**
     * 获取token
     * @param string $grant_type 获取类型
     * @return array
     * @see https://developers.weixin.qq.com/doc/offiaccount/Basic_Information/Get_access_token.html
     */
    public function token(string $grant_type): array
    {
        return $this->httpGet("/token?grant_type=$grant_type&appid=$this->appid&secret=$this->appsecret", true, false);
    }

    /**
     * 获取微信API接口 IP地址
     * @return array
     * @see https://developers.weixin.qq.com/doc/offiaccount/Basic_Information/Get_the_WeChat_server_IP_address.html
     */
    public function getApiDomainIp(): array
    {
        $this->getAccessToken();
        $result = $this->httpGet("/get_api_domain_ip?access_token=$this->accessToken");
        return $result['ip_list'];
    }

    /**
     * 获取微信callback IP地址
     * @return array
     * @see https://developers.weixin.qq.com/doc/offiaccount/Basic_Information/Get_the_WeChat_server_IP_address.html
     */
    public function getcallbackip(): array
    {
        $this->getAccessToken();
        $result = $this->httpGet("/getcallbackip?access_token=$this->accessToken");
        return $result['ip_list'];
    }

    /**
     * 长连接转短链接
     * @param string $long_url 需要转换的长链接
     * @return string
     * @deprecated 2021年03月15日后将停止该接口生成短链能力
     * @see https://developers.weixin.qq.com/doc/offiaccount/Account_Management/URL_Shortener.html
     */
    public function shorturl(string $long_url): string
    {
        $this->getAccessToken();
        $params = [
            'action'   => 'long2short',
            'long_url' => $long_url
        ];
        $result = $this->httpPost("/shorturl?access_token=$this->accessToken", $params);
        return $result['short_url'];
    }

    /**
     * 查询自定义菜单
     * @return array
     * @see https://developers.weixin.qq.com/doc/offiaccount/Custom_Menus/Querying_Custom_Menus.html
     */
    public function getCurrentSelfmenuInfo(): array
    {
        $this->getAccessToken();
        return $this->httpGet("/get_current_selfmenu_info?access_token=$this->accessToken");
    }

    /**
     * 清空api的调用quota
     * @see https://developers.weixin.qq.com/doc/offiaccount/openApi/clear_quota.html
     */
    public function clearQuota()
    {
        $this->getAccessToken();
        $params = [
            'appid' => $this->appid
        ];
        $this->httpPost("/clear_quota?access_token=$this->accessToken", $params);
    }

    /**
     * 获取公众号的自动回复规则
     * @return array
     * @link https://developers.weixin.qq.com/doc/offiaccount/Message_Management/Getting_Rules_for_Auto_Replies.html
     */
    public function getCurrentAutoreplyInfo(): array
    {
        $this->getAccessToken();
        return $this->httpGet("/get_current_autoreply_info?access_token=$this->accessToken");
    }
}
