<?php


namespace fize\third\wechat\api;


use fize\third\wechat\Api;


/**
 * 开放授权
 */
class Oauth2 extends Api
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
     * 通过code换取网页授权access_token
     * @param string $code 获取到的code
     * @return array
     */
    public function accessToken($code)
    {
        return $this->httpGet("/sns/oauth2/access_token?appid={$this->appid}&secret={$this->appsecret}&code={$code}&grant_type=authorization_code", true, false, '');
    }

    /**
     * 刷新access_token
     * @param string $refresh_token refresh_token
     * @return array
     */
    public function refreshToken($refresh_token)
    {
        return $this->httpGet("/sns/oauth2/refresh_token?appid={$this->appid}&grant_type=refresh_token&refresh_token={$refresh_token}", true, false, '');
    }
}
