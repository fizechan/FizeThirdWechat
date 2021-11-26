<?php


namespace Fize\Third\Wechat\Api\Merchant;

use Fize\Third\Wechat\Api;

/**
 * 商品分类
 */
class Category extends Api
{

    /**
     * 获取指定分类的所有子分类
     * @param int $cate_id 大分类ID
     * @return array
     */
    public function getsub($cate_id)
    {
        $params = [
            'cate_id' => $cate_id
        ];
        return $this->httpPost("/merchant/category/getsub?access_token={$this->accessToken}", $params);
    }

    /**
     * 获取指定子分类的所有SKU
     * @param int $cate_id 大分类ID
     * @return array
     */
    public function getsku($cate_id)
    {
        $params = [
            'cate_id' => $cate_id
        ];
        return $this->httpPost("/merchant/category/getsku?access_token={$this->accessToken}", $params);
    }

    /**
     * 获取指定分类的所有属性
     * @param int $cate_id 大分类ID
     * @return array
     */
    public function getproperty($cate_id)
    {
        $params = [
            'cate_id' => $cate_id
        ];
        return $this->httpPost("/merchant/category/getproperty?access_token={$this->accessToken}", $params);
    }
}
