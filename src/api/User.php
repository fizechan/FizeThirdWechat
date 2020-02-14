<?php


namespace fize\third\wechat\offiaccount;


use fize\third\wechat\Offiaccount;


/**
 * 用户管理
 */
class User extends Offiaccount
{

    /**
     * 获取用户基本信息（包括UnionID机制）
     *
     * unionid字段 只有在用户将公众号绑定到微信开放平台账号后，才会出现。建议调用前用isset()检测一下
     * @param string $openid 用户openid
     * @param string $lang 国家地区语言版本
     * @return array|false
     */
    public function info($openid, $lang = null)
    {
        $uri = "/user/info?access_token={$this->accessToken}&openid={$openid}";
        if (!is_null($lang)) {
            $uri .= "&lang={$lang}";
        }
        return $this->httpGet($uri);
    }

    /**
     * 获取用户列表
     * @param string $next_openid 第一个拉取的OPENID，不填默认从头开始拉取
     * @return array|false
     */
    public function get($next_openid = null)
    {
        $uri = "/user/get?access_token={$this->accessToken}";
        if (!is_null($next_openid)) {
            $uri .= "&next_openid={$next_openid}";
        }
        return $this->httpGet($uri);
    }
}
