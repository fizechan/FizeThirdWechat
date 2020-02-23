<?php


namespace fize\third\wechat\api;

use fize\third\wechat\Api;
use fize\third\wechat\ApiException;

/**
 * 社交网络
 * @todo 待优化
 */
class Sns extends Api
{

    /**
     * 构造
     * @param array $options 参数数组
     */
    public function __construct($options)
    {
        parent::__construct($options, false);
    }

    /**
     * 拉取用户信息
     * @param string $access_token 授权access_token
     * @param string $openid 用户openid
     * @param string $lang 国家地区语言版本
     * @return array
     */
    public function userinfo($access_token, $openid, $lang = 'zh_CN')
    {
        return $this->httpGet("/sns/userinfo?access_token={$access_token}&openid={$openid}&lang={$lang}", true, false, '');
    }

    /**
     * 检验授权凭证是否有效
     * @param string $access_token 授权access_token
     * @param string $openid 用户openid
     * @return bool
     */
    public function auth($access_token, $openid)
    {
        try {
            $this->httpGet("/sns/auth?access_token={$access_token}&openid={$openid}", true, false, '');
            return true;
        } catch (ApiException $exception) {
            return false;
        }
    }
}
