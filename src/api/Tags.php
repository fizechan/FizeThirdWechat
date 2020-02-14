<?php


namespace fize\third\wechat\offiaccount;

use fize\third\wechat\Offiaccount;

/**
 * 用户标签管理
 */
class Tags extends Offiaccount
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
}
