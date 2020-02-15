<?php


namespace fize\third\wechat\api;

use fize\third\wechat\Api;

/**
 * 微信门店小程序
 */
class Wxa extends Api
{

    /**
     * 拉取门店小程序类目
     * @return array
     */
    public function getMerchantCategory()
    {
        return $this->httpGet("/wxa/get_merchant_category?access_token={$this->accessToken}");
    }

    public function applyMerchant()
    {

    }
}
