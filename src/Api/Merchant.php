<?php


namespace Fize\Third\Wechat\Api;

use Fize\Third\Wechat\ApiAbstract;

/**
 * 商品管理
 */
class Merchant extends ApiAbstract
{

    /**
     * 1.1增加商品
     * @param array $params 参数
     * @return array
     */
    public function create(array $params)
    {
        return $this->httpPost("/merchant/create?access_token={$this->accessToken}", $params);
    }

    /**
     * 删除商品
     * @param string $product_id 商品ID
     * @return bool
     */
    public function del($product_id)
    {
        $params = [
            'product_id' => $product_id
        ];
        return $this->httpPost("/merchant/del?access_token={$this->accessToken}", $params);
    }

    /**
     * 修改商品
     * @param string $product_id 商品ID
     * @param array  $params     参数
     * @return bool
     */
    public function update($product_id, array $params)
    {
        $params = array_merge(['product_id' => $product_id], $params);
        return $this->httpPost("/merchant/update?access_token={$this->accessToken}", $params);
    }

    /**
     * 查询商品
     * @param string $product_id 商品ID
     * @return array
     */
    public function get($product_id)
    {
        $params = [
            'product_id' => $product_id
        ];
        return $this->httpPost("/merchant/get?access_token={$this->accessToken}", $params);
    }

    /**
     * 获取指定状态的所有商品
     * @param int $status 状态
     * @return array
     */
    public function getbystatus($status)
    {
        $params = [
            'status' => $status
        ];
        return $this->httpPost("/merchant/getbystatus?access_token={$this->accessToken}", $params);
    }

    /**
     * 商品上下架
     * @param string $product_id 商品ID
     * @param int    $status     上下架
     * @return array
     */
    public function modproductstatus($product_id, $status)
    {
        $params = [
            'product_id' => $product_id,
            'status'     => $status
        ];
        return $this->httpPost("/merchant/modproductstatus?access_token={$this->accessToken}", $params);
    }
}
