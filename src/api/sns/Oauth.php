<?php


namespace fize\third\wechat\api;


use fize\third\wechat\Api;


/**
 * 微信Oauth网页授权登录类
 */
class Oauth extends Api
{

    const PREFIX_OAUTH = 'https://open.weixin.qq.com/connect/oauth2';

    const URL_OAUTH_AUTHORIZE = '/authorize?';

    const URL_OAUTH_TOKEN = '/sns/oauth2/access_token?';

    const URL_OAUTH_REFRESH = '/sns/oauth2/refresh_token?';

    const URL_OAUTH_USERINFO = '/sns/userinfo?';

    const URL_OAUTH_AUTH = '/sns/auth?';

    /**
     * session键名，用于判断code的一次性使用
     */
    const KEY_SESSION_CODE = '__WECHAT_CODE__';

    /**
     * 构造函数
     * @param array $options 参数数组
     */
    public function __construct($options)
    {
        parent::__construct($options);
    }

    /**
     * oauth 授权跳转接口
     * @param string $callback 回调URL
     * @param string $state
     * @param string $scope 默认为
     * @return string
     */
    public function getOauthRedirect($callback, $state = 'one', $scope = 'snsapi_base')
    {
        return self::PREFIX_OAUTH . self::URL_OAUTH_AUTHORIZE . 'appid=' . $this->appid . '&redirect_uri=' . urlencode($callback) . '&response_type=code&scope=' . $scope . '&state=' . $state . '#wechat_redirect';
    }

    /**
     * 通过code获取Access Token
     * @param string $code 获取到的code
     * @return mixed 失败时返回false
     */
    public function getOauthAccessToken($code)
    {
        //$code = isset($_GET['code'])?$_GET['code']:'';
        if (!$code) return false;
        return $this->httpGet(self::PREFIX_API . self::URL_OAUTH_TOKEN . 'appid=' . $this->appid . '&secret=' . $this->appsecret . '&code=' . $code . '&grant_type=authorization_code');
    }

    /**
     * 刷新access token并续期
     * @param string $refresh_token
     * @return bool
     */
    public function getOauthRefreshToken($refresh_token)
    {
        return $this->httpGet(self::PREFIX_API . self::URL_OAUTH_REFRESH . 'appid=' . $this->appid . '&grant_type=refresh_token&refresh_token=' . $refresh_token);
    }

    /**
     * 获取授权后的用户资料
     * @param string $access_token
     * @param string $openid
     * @return array {openid,nickname,sex,province,city,country,headimgurl,privilege,[unionid]}
     * 注意：unionid字段 只有在用户将公众号绑定到微信开放平台账号后，才会出现。建议调用前用isset()检测一下
     */
    public function getOauthUserinfo($access_token, $openid)
    {
        return $this->httpGet(self::PREFIX_API . self::URL_OAUTH_USERINFO . 'access_token=' . $access_token . '&openid=' . $openid);
    }

    /**
     * 检验授权凭证是否有效
     * @param string $access_token
     * @param string $openid
     * @return boolean 是否有效
     */
    public function getOauthAuth($access_token, $openid)
    {
        $result = $this->httpGet(self::PREFIX_API . self::URL_OAUTH_AUTH . 'access_token=' . $access_token . '&openid=' . $openid);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 使用了一个code
     * @param string $p_code
     */
    private function _use_code_($p_code)
    {
        $t_session = $_SESSION[self::KEY_SESSION_CODE];
        if (empty($t_session)) {
            $t_session = $p_code;
        } else {
            $t_session .= "," . $p_code;
        }
        $_SESSION[self::KEY_SESSION_CODE] = $t_session;
    }

    /**
     * 判断code可用性
     * @param string $p_code
     * @return boolean
     */
    private function _code_viable_($p_code)
    {
        $t_session = $_SESSION[self::KEY_SESSION_CODE];
        $t_pos = strstr($t_session, $p_code);
        if ($t_pos === false) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 简易OAUTH,仅获取base信息
     * @param string $p_openid 已有OPENID,如果判断为空则进行OAUTH
     * @param string $p_rdurl 回调链接,如果为空则为当前链接
     * @return mixed 失败时返回false
     */
    public function oauthBase($p_openid, $p_rdurl = "")
    {
        $t_rst = false;
        if (isset($p_openid) && !empty($p_openid)) {
            //$t_openid = $p_openid;
        } else {
            //检测参数为空时进行授权
            if (!isset($p_rdurl) || empty($p_rdurl)) {
                $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
                $p_rdurl = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
            }
            if (isset($_GET['code']) && !empty($_GET['code']) && $this->_code_viable_($_GET['code'])) {
                $t_rst = $this->getOauthAccessToken($_GET['code']);
                if ($t_rst) {
                    $this->_use_code_($_GET['code']);
                    //此处已经获取到openid
                    //$t_openid = $t_rst['openid'];
                } else {
                    //再验证一次
                    if (isset($_GET['state']) && $_GET['state'] == 'one') {
                        //二次授权
                        header("Location: " . $this->getOauthRedirect($p_rdurl, 'two'));
                        exit();
                    } else {
                        //写入错误日志
                        //Log::write('获取用户OPENID时发生错误,错误代码' . $this->errCode, 'ERR');
                        return false;
                    }
                }
            } else {
                //跳转到授权页面
                header("Location: " . $this->getOauthRedirect($p_rdurl, 'one'));
                exit();
            }
        }
        return $t_rst;    //直接返回
        //return $t_openid;
    }

    /**
     * 完整OAUTH,获取全部有用信息
     * @param string $p_rdurl 回转的链接
     * @return mixed 失败时返回false
     */
    public function oauthInfo($p_rdurl = "")
    {
        if (!isset($p_rdurl) || empty($p_rdurl)) {
            $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
            $p_rdurl = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        }
        $t_scope = 'snsapi_userinfo';
        $t_state = 'one';
        if (isset($_GET['code']) && !empty($_GET['code']) && $this->_code_viable_($_GET['code'])) {
            $t_rst = $this->getOauthAccessToken($_GET['code']);
            if ($t_rst) {
                $this->_use_code_($_GET['code']);
                //此处已经获取到openid
                $t_openid = $t_rst['openid'];
                $t_token = $t_rst['access_token'];
                //拉取其他信息
                if (isset($t_openid) && isset($t_token)) {
                    $t_user = $this->getOauthUserinfo($t_token, $t_openid);
                    if ($t_user) {
                        return $t_user;
                    } else {
                        //写入错误日志
                        //Log::write('获取用户信息时发生错误,错误代码' . $this->errCode, 'ERR');
                        return false;
                    }
                }
            } else {
                //再验证一次
                if (isset($_GET['state']) && $_GET['state'] == 'one') {
                    //二次授权
                    $t_state = 'two';
                    header("Location: " . $this->getOauthRedirect($p_rdurl, $t_state, $t_scope));
                    exit();
                } else {
                    //写入错误日志
                    //Log::write('微信授权时发生错误,错误代码' . $this->errCode, 'ERR');
                    return false;
                }
            }
        } else {
            //跳转到授权页面
            header("Location: " . $this->getOauthRedirect($p_rdurl, $t_state, $t_scope));
            exit();
        }
        return null;
    }
}
