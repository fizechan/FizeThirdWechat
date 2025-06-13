<?php

namespace Fize\Third\Wechat;

use Fize\Third\Wechat\Api\SNS;
use Fize\Third\Wechat\Api\SNS\Oauth2 as ApiOauth2;
use Fize\Third\Wechat\Open\Connect\Oauth2 as OpenOauth2;

/**
 * 网页授权
 */
class Oauth2
{

    /**
     * @var string 唯一凭证
     */
    protected $appid;

    /**
     * @var string APP密钥
     */
    protected $appsecret;

    /**
     * @var OpenOauth2 OpenOauth2对象
     */
    protected $openOauth2;

    /**
     * @var ApiOauth2 ApiOauth2对象
     */
    protected $apiOauth2;

    /**
     * 构造
     * @param string $appid     APPID
     * @param string $appsecret APP密钥
     */
    public function __construct(string $appid, string $appsecret)
    {
        $this->appid = $appid;
        $this->appsecret = $appsecret;
        $this->openOauth2 = new OpenOauth2($appid, $appsecret);
        $this->apiOauth2 = new ApiOauth2($appid, $appsecret);
    }

    /**
     * 简易OAUTH2,获取基本信息
     * @param string|null $redirect_uri 回调链接,如果为空则为当前链接
     * @param string|null $state        自定义参数
     * @return array
     */
    public function base(string $redirect_uri = null, string $state = null): array
    {
        if (empty($redirect_uri)) {
            $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
            $redirect_uri = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        }

        if (!isset($_GET['code']) || empty($_GET['code'])) {
            // 跳转到授权页面
            header("Location: " . $this->openOauth2->authorize($redirect_uri, OpenOauth2::SCOPE_SNSAPI_BASE, $state));
            exit();
        }

        return $this->apiOauth2->accessToken($_GET['code']);
    }

    /**
     * 完整OAUTH2,获取完整信息
     * @param string|null $redirect_uri 回调链接,如果为空则为当前链接
     * @param string|null $state        自定义参数
     * @param string      $lang         国家地区语言版本
     * @return array
     */
    public function userinfo(string $redirect_uri = null, string $state = null, string $lang = 'zh_CN'): array
    {
        if (empty($redirect_uri)) {
            $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
            $redirect_uri = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        }

        if (!isset($_GET['code']) || empty($_GET['code'])) {
            // 跳转到授权页面
            header("Location: " . $this->openOauth2->authorize($redirect_uri, OpenOauth2::SCOPE_SNSAPI_USERINFO, $state));
            exit();
        }

        $result = $this->apiOauth2->accessToken($_GET['code']);

        $sns = new Sns($this->appid, $this->appsecret);
        return $sns->userinfo($result['access_token'], $result['openid'], $lang);
    }
}
