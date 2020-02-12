<?php


namespace fize\third\wechat\api;

use fize\third\wechat\Api;

/**
 * 用户标签管理
 */
class Tags extends Api
{

    /**
     * 创建标签
     * @param string $name 标签名
     * @return array|false
     */
    public function create($name)
    {
        $params = [
            'tag' => [
                'name' => $name
            ]
        ];
        $json = $this->httpPost("/tags/create?access_token={$this->accessToken}", $params);
        if (!$json) {
            return false;
        }
        return $json['tag'];
    }

    /**
     * 获取公众号已创建的标签
     * @return array|false
     */
    public function get()
    {
        return $this->httpGet("/tags/get?access_token={$this->accessToken}");
    }

    /**
     * 编辑标签
     * @param int $id 标签ID
     * @param string $name 标签名
     * @return bool
     */
    public function update($id, $name)
    {
        $params = [
            'tag' => [
                'id'   => $id,
                'name' => $name
            ]
        ];
        $result = $this->httpPost("/tags/update?access_token={$this->accessToken}", $params);
        return $result ? true : false;
    }

    /**
     * 删除标签
     * @param int $id 标签ID
     * @return bool
     */
    public function delete($id)
    {
        $params = [
            'tag' => [
                'id' => $id
            ]
        ];
        $result = $this->httpPost("/tags/delete?access_token={$this->accessToken}", $params);
        return $result ? true : false;
    }

    /**
     * 批量为用户打标签
     * @param array $openid_list 用户列表
     * @param int $tagid 标签ID
     * @return bool
     */
    public function membersBatchTagging(array $openid_list, $tagid)
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
    public function membersBatchUnTagging(array $openid_list, $tagid)
    {
        $params = [
            'openid_list' => $openid_list,
            'tagid'       => $tagid
        ];
        $result = $this->httpPost("/tags/members/batchuntagging?access_token={$this->accessToken}", $params);
        return $result ? true : false;
    }

    /**
     * 获取用户身上的标签列表
     * @param string $openid 用户openid
     * @return array|false
     */
    public function getidlist($openid)
    {
        $params = [
            'openid' => $openid
        ];
        $json = $this->httpPost("/tags/getidlist?access_token={$this->accessToken}", $params);
        if (!$json) {
            return false;
        }
        return $json['tagid_list'];
    }

    /**
     * 获取公众号的黑名单列表
     * @param string $begin_openid 开始openid
     * @return array|false
     */
    public function membersGetblacklist($begin_openid = '')
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
    public function membersBatchblacklist($openid_list)
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
    public function membersBatchunblacklist($openid_list)
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
