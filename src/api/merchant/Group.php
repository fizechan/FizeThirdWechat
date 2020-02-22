<?php


namespace fize\third\wechat\api\merchant;

use fize\third\wechat\Api;

/**
 * 分组管理
 */
class Group extends Api
{

    /**
     * 增加分组
     * @param string $group_name 分组名称
     * @param array $product_list 商品ID集合
     * @return array|string
     */
    public function add($group_name, array $product_list)
    {
        $params = [
            'group_detail' => [
                'group_name' => $group_name,
                'product_list' => $product_list
            ]
        ];
        return $this->httpPost("/merchant/group/add?access_token={$this->accessToken}", $params);
    }

    /**
     * 删除分组
     * @param int $group_id 分组ID
     * @return bool
     */
    public function del($group_id)
    {
        $params = [
            'group_id' => $group_id
        ];
        return $this->httpPost("/merchant/group/del?access_token={$this->accessToken}", $params);
    }

    /**
     * 修改分组属性
     * @param $group_id
     * @param $group_name
     * @return bool
     */
    public function propertymod($group_id, $group_name)
    {
        $params = [
            'group_id' => $group_id,
            'group_name' => $group_name
        ];
        return $this->httpPost("/merchant/group/propertymod?access_token={$this->accessToken}", $params);
    }

    /**
     * 修改分组商品
     * @param $group_id
     * @param array $product
     * @return bool
     */
    public function productmod($group_id, array $product)
    {
        $params = [
            'group_id' => $group_id,
            'product' => $product
        ];
        return $this->httpPost("/merchant/group/productmod?access_token={$this->accessToken}", $params);
    }

    /**
     * 获取所有分组
     * @return array
     */
    public function getall()
    {
        return $this->httpGet("/merchant/group/productmod?access_token={$this->accessToken}");
    }

    /**
     * 根据分组ID获取分组信息
     * @param $group_id
     * @return array
     */
    public function getbyid($group_id)
    {
        $params = [
            'group_id' => $group_id
        ];
        return $this->httpPost("/merchant/group/getbyid?access_token={$this->accessToken}", $params);
    }
}
