<?php


namespace fize\third\wechat\open\connect;


use fize\third\wechat\Open;
use fize\third\wechat\api\Oauth2 as ApiOauth2;
use fize\third\wechat\api\Sns as ApiSns;

/**
 * 网页授权
 */
class Oauth2 extends Open
{

    const SCOPE_SNSAPI_BASE = 'snsapi_base';

    const SCOPE_SNSAPI_USERINFO = 'snsapi_userinfo';

    /**
     * 获取授权
     * @param string $redirect_uri 同意授权后跳转URI
     * @param string $scope 授权作用域
     * @param string $state 自定义参数
     * @return string 返回URI
     */
    public function authorize($redirect_uri, $scope, $state = null)
    {
        $redirect_uri = urlencode($redirect_uri);
        $uri = "https://" . self::HOST . "/connect/oauth2/authorize?appid={$this->appid}&redirect_uri={$redirect_uri}&response_type=code&scope={$scope}";
        if (!is_null($state)) {
            $uri .= "&state={$state}";
        }
        $uri .= "#wechat_redirect";
        return $uri;
    }

    /**
     * 简易OAUTH2,获取基本信息
     * @param string $redirect_uri 回调链接,如果为空则为当前链接
     * @param string $state 自定义参数
     * @return array
     */
    public function userbase($redirect_uri = null, $state = null)
    {
        if (empty($redirect_uri)) {
            $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
            $redirect_uri = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        }

        if (!isset($_GET['code']) || empty($_GET['code'])) {
            //跳转到授权页面
            header("Location: " . $this->authorize($redirect_uri, self::SCOPE_SNSAPI_BASE, $state));
            exit();
        }

        $config = [
            'appid'     => $this->appid,
            'appsecret' => $this->appsecret
        ];
        $oauth2 = new ApiOauth2($config);
        return $oauth2->accessToken($_GET['code']);
    }

    /**
     * 完整OAUTH2,获取完整信息
     * @param string $redirect_uri 回调链接,如果为空则为当前链接
     * @param string $state 自定义参数
     * @param string $lang 国家地区语言版本
     * @return array
     */
    public function userinfo($redirect_uri = null, $state = null, $lang = 'zh_CN')
    {
        if (empty($redirect_uri)) {
            $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
            $redirect_uri = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        }

        if (!isset($_GET['code']) || empty($_GET['code'])) {
            //跳转到授权页面
            header("Location: " . $this->authorize($redirect_uri, self::SCOPE_SNSAPI_USERINFO, $state));
            exit();
        }

        $config = [
            'appid'     => $this->appid,
            'appsecret' => $this->appsecret
        ];
        $oauth2 = new ApiOauth2($config);
        $result = $oauth2->accessToken($_GET['code']);

        $sns = new ApiSns($config);
        return $sns->userinfo($result['access_token'], $result['openid'], $lang);
    }
}
