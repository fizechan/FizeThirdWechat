<?php

namespace Fize\Third\Wechat;

/**
 * 微信接口V2
 */
class ApiV2 extends ApiAbstract
{

    /**
     * @var bool 是否初始化时马上检测AccessToken
     */
    protected $checkAccessToken = false;

    public static $APIS = [
        'getAccessToken' => ["/cgi-bin/token?grant_type={$grant_type}&appid={$this->appid}&secret={$this->appsecret}"],
        'clearQuota' => ["/cgi-bin/clear_quota"],
    ];

    /**
     * 获取token
     * @param string $grant_type 获取类型
     * @return array
     * @see https://developers.weixin.qq.com/doc/offiaccount/Basic_Information/Get_access_token.html
     */
    public function call($api, array $params = []): array
    {
        switch ($api) {
            case 'getAccessToken':
                $url = self::$APIS[$api][0];
                break;
            default:
                $url = self::$APIS[$api][1];
                break;
        }

        return $this->httpGet("/token?grant_type=$grant_type&appid=$this->appid&secret=$this->appsecret", true, false);
    }
}
