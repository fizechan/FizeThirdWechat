<?php


namespace fize\third\wechat\api\tags;

use fize\third\wechat\Api;

/**
 * 标签用户
 */
class Members extends Api
{
    /**
     * 批量为用户打标签
     * @param array $openid_list 用户列表
     * @param int $tagid 标签ID
     */
    public function batchtagging(array $openid_list, $tagid)
    {
        $params = [
            'openid_list' => $openid_list,
            'tagid'       => $tagid
        ];
        $this->httpPost("/tags/members/batchtagging?access_token={$this->accessToken}", $params);
    }

    /**
     * 批量为用户取消标签
     * @param array $openid_list 用户列表
     * @param int $tagid 标签ID
     */
    public function batchuntagging(array $openid_list, $tagid)
    {
        $params = [
            'openid_list' => $openid_list,
            'tagid'       => $tagid
        ];
        $this->httpPost("/tags/members/batchuntagging?access_token={$this->accessToken}", $params);
    }

    /**
     * 获取公众号的黑名单列表
     * @param string $begin_openid 开始openid
     * @return array
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
     */
    public function batchblacklist($openid_list)
    {
        if (!is_array($openid_list)) {
            $openid_list = [$openid_list];
        }
        $params = [
            'openid_list' => $openid_list
        ];
        $this->httpPost("/tags/members/batchblacklist?access_token={$this->accessToken}", $params);
    }

    /**
     * 取消拉黑用户
     * @param string|array $openid_list 需要拉入黑名单的用户的openid
     */
    public function batchunblacklist($openid_list)
    {
        if (!is_array($openid_list)) {
            $openid_list = [$openid_list];
        }
        $params = [
            'openid_list' => $openid_list
        ];
        $this->httpPost("/tags/members/batchunblacklist?access_token={$this->accessToken}", $params);
    }
}
