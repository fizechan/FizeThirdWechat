<?php


namespace Fize\Third\Wechat\Open\Connect;


use Fize\Third\Wechat\Open;

/**
 * 网页授权
 */
class Oauth2 extends Open
{

    /**
     * 授权作用域：基础信息
     */
    const SCOPE_SNSAPI_BASE = 'snsapi_base';

    /**
     * 授权作用域：完整信息
     */
    const SCOPE_SNSAPI_USERINFO = 'snsapi_userinfo';

    /**
     * 获取授权
     * @param string      $redirect_uri  同意授权后跳转URI
     * @param string      $scope         授权作用域
     * @param string|null $state         自定义参数
     * @param string|null $agentid       应用agentid
     * @param string      $response_type 返回类型
     * @return string 返回授权URL
     */
    public function authorize(string $redirect_uri, string $scope, string $state = null, string $agentid = null, string $response_type = 'code'): string
    {
        $redirect_uri = urlencode($redirect_uri);
        $url = "https://" . self::HOST . "/connect/oauth2/authorize?appid={$this->appid}&redirect_uri={$redirect_uri}&response_type={$response_type}&scope={$scope}";
        if (!is_null($state)) {
            $url .= "&state={$state}";
        }
        if (!is_null($agentid)) {
            $url .= "&agentid={$agentid}";
        }
        $url .= "#wechat_redirect";
        return $url;
    }
}
