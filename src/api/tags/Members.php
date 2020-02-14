<?php


namespace fize\third\wechat\offiaccount\tags;

use fize\third\wechat\Offiaccount;

/**
 * 标签用户
 */
class Members extends Offiaccount
{
    /**
     * 批量为用户打标签
     * @param array $openid_list 用户列表
     * @param int $tagid 标签ID
     * @return bool
     */
    public function batchtagging(array $openid_list, $tagid)
    {
        $params = [
            'openid_list' => $openid_list,
            'tagid'       => $tagid
        ];
        $result = $this->httpPost("/tags/members/batchtagging?access_token={$this->accessToken}", $params);
        return $result ? true : false;
    }

    /**
     * 批量为用户取消标签
     * @param array $openid_list 用户列表
     * @param int $tagid 标签ID
     * @return bool
     */
    public function batchuntagging(array $openid_list, $tagid)
    {
        $params = [
            'openid_list' => $openid_list,
            'tagid'       => $tagid
        ];
        $result = $this->httpPost("/tags/members/batchuntagging?access_token={$this->accessToken}", $params);
        return $result ? true : false;
    }

    /**
     * 获取公众号的黑名单列表
     * @param string $begin_openid 开始openid
     * @return array|false
     */
    public function getblacklist($begin_openid = '')
    {
        $params = [
            'begin_openid' => $begin_openid
        ];
        return $this->httpPost("/tags/members/getblacklist?access_token={$this->accessToken}", $params);
    }

    /**
     * 拉黑用户
     * @param string|array $openid_list 需要拉入黑名单的用户的openid
     * @return bool
     */
    public function batchblacklist($openid_list)
    {
        if (!is_array($openid_list)) {
            $openid_list = [$openid_list];
        }
        $params = [
            'openid_list' => $openid_list
        ];
        $result = $this->httpPost("/tags/members/batchblacklist?access_token={$this->accessToken}", $params);
        return $result ? true : false;
    }

    /**
     * 取消拉黑用户
     * @param string|array $openid_list 需要拉入黑名单的用户的openid
     * @return bool
     */
    public function batchunblacklist($openid_list)
    {
        if (!is_array($openid_list)) {
            $openid_list = [$openid_list];
        }
        $params = [
            'openid_list' => $openid_list
        ];
        $result = $this->httpPost("/tags/members/batchunblacklist?access_token={$this->accessToken}", $params);
        return $result ? true : false;
    }
}
