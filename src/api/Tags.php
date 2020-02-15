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
        $result = $this->httpPost("/tags/create?access_token={$this->accessToken}", $params);
        return $result['tag'];
    }

    /**
     * 获取公众号已创建的标签
     * @return array
     */
    public function get()
    {
        return $this->httpGet("/tags/get?access_token={$this->accessToken}");
    }

    /**
     * 编辑标签
     * @param int $id 标签ID
     * @param string $name 标签名
     */
    public function update($id, $name)
    {
        $params = [
            'tag' => [
                'id'   => $id,
                'name' => $name
            ]
        ];
        $this->httpPost("/tags/update?access_token={$this->accessToken}", $params);
    }

    /**
     * 删除标签
     * @param int $id 标签ID
     */
    public function delete($id)
    {
        $params = [
            'tag' => [
                'id' => $id
            ]
        ];
        $this->httpPost("/tags/delete?access_token={$this->accessToken}", $params);
    }

    /**
     * 获取用户身上的标签列表
     * @param string $openid 用户openid
     * @return array
     */
    public function getidlist($openid)
    {
        $params = [
            'openid' => $openid
        ];
        $result = $this->httpPost("/tags/getidlist?access_token={$this->accessToken}", $params);
        return $result['tagid_list'];
    }
}
