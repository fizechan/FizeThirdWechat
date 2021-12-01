<?php


namespace Fize\Third\Wechat\Api;

use Fize\Exception\ThirdException;
use Fize\Third\Wechat\ApiAbstract;

/**
 * 社交网络
 */
class Sns extends ApiAbstract
{

    /**
     * @var bool 是否初始化时马上检测AccessToken
     */
    protected $checkAccessToken = false;

    /**
     * 拉取用户信息
     * @param string $access_token 授权access_token
     * @param string $openid       用户openid
     * @param string $lang         国家地区语言版本
     * @return array
     */
    public function userinfo(string $access_token, string $openid, string $lang = 'zh_CN'): array
    {
        return $this->httpGet("/sns/userinfo?access_token=$access_token&openid=$openid&lang=$lang", true, false, '');
    }

    /**
     * 检验授权凭证是否有效
     * @param string $access_token 授权access_token
     * @param string $openid       用户openid
     * @return bool
     */
    public function auth(string $access_token, string $openid): bool
    {
        try {
            $this->httpGet("/sns/auth?access_token=$access_token&openid=$openid", true, false, '');
            return true;
        } catch (ThirdException $exception) {
            return false;
        }
    }
}
