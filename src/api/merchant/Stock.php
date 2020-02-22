<?php


namespace fize\third\wechat\api\merchant;

use fize\third\wechat\Api;

/**
 * 库存管理
 */
class Stock extends Api
{

    /**
     * 增加库存
     * @param string $product_id 商品ID
     * @param mixed $sku_info SKU信息
     * @param int $quantity 数量
     * @return bool
     */
    public function add($product_id, $sku_info, $quantity)
    {
        $params = [
            'product_id' => $product_id,
            'sku_info' => $sku_info,
            'quantity' => $quantity
        ];
        return $this->httpPost("/merchant/stock/add?access_token={$this->accessToken}", $params);
    }

    /**
     * 库存
     * @param string $product_id 商品ID
     * @param mixed $sku_info SKU信息
     * @param int $quantity 数量
     * @return bool
     */
    public function reduce($product_id, $sku_info, $quantity)
    {
        $params = [
            'product_id' => $product_id,
            'sku_info' => $sku_info,
            'quantity' => $quantity
        ];
        return $this->httpPost("/merchant/stock/reduce?access_token={$this->accessToken}", $params);
    }
}
