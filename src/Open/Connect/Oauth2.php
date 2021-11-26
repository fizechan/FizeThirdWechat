<?php


namespace Fize\Third\Wechat\open\Connect;


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
     * @param string      $redirect_uri 同意授权后跳转URI
     * @param string      $scope        授权作用域
     * @param string|null $state        自定义参数
     * @return string 返回授权URI
     */
    public function authorize(string $redirect_uri, string $scope, string $state = null): string
    {
        $redirect_uri = urlencode($redirect_uri);
        $uri = "https://" . self::HOST . "/connect/oauth2/authorize?appid=$this->appid&redirect_uri=$redirect_uri&response_type=code&scope=$scope";
        if (!is_null($state)) {
            $uri .= "&state=$state";
        }
        $uri .= "#wechat_redirect";
        return $uri;
    }
}
