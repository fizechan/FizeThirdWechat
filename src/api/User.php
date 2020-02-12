<?php


namespace fize\third\wechat\api;


use fize\third\wechat\Api;


/**
 * 用户管理
 */
class User extends Api
{

    /**
     * 获取标签下粉丝列表
     * @param int $tagid 标签ID
     * @param string $next_openid 第一个拉取的OPENID，不填默认从头开始拉取
     * @return array|false
     */
    public function tagGet($tagid, $next_openid = '')
    {
        $params = [
            'tagid'       => $tagid,
            'next_openid' => $next_openid
        ];
        return $this->httpPost("/user/tag/get?access_token={$this->accessToken}", $params);
    }

    /**
     * 设置用户备注名
     * @param string $openid
     * @param string $remark 备注名
     * @return bool
     */
    public function infoUpdateUserRemark($openid, $remark)
    {
        $params = [
            'openid' => $openid,
            'remark' => $remark
        ];
        $result = $this->httpPost("/user/info/updateremark?access_token={$this->accessToken}", $params);
        return $result ? true : false;
    }

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
     * 批量获取用户基本信息
     * @param array $users 用户列表
     * @return array|false
     */
    public function infoBatchGet(array $users)
    {
        $user_list = [];
        foreach ($users as $user) {
            if (is_string($user)) {
                $user_list[] = [
                    'openid' => $user
                ];
            } else {
                $user_list[] = $user;
            }
        }
        $params = [
            'user_list' => $user_list
        ];
        return $this->httpPost("/user/info/batchget?access_token={$this->accessToken}", $params);
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
