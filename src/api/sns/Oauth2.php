<?php


namespace fize\third\wechat\api\sns;


use fize\third\wechat\Api;


/**
 * 开放授权
 */
class Oauth2 extends Api
{

    /**
     * @var bool 是否初始化时马上检测AccessToken
     */
    protected $checkAccessToken = false;

    /**
     * 通过code换取网页授权access_token
     * @param string $code 获取到的code
     * @return array
     */
    public function accessToken(string $code): array
    {
        return $this->httpGet("/sns/oauth2/access_token?appid=$this->appid&secret=$this->appsecret&code=$code&grant_type=authorization_code", true, false, '');
    }

    /**
     * 刷新access_token
     * @param string $refresh_token refresh_token
     * @return array
     */
    public function refreshToken(string $refresh_token): array
    {
        return $this->httpGet("/sns/oauth2/refresh_token?appid=$this->appid&grant_type=refresh_token&refresh_token=$refresh_token", true, false, '');
    }
}
