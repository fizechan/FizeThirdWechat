<?php


namespace fize\third\wechat\api\card\giftcard\pay;

use fize\third\wechat\Api;

/**
 * 小程序
 */
class Submch extends Api
{

    /**
     * 绑定商户号到礼品卡小程序
     * @param string $sub_mch_id 商户号
     * @param string $wxa_appid 小程序APPID
     */
    public function bind($sub_mch_id, $wxa_appid)
    {
        $params = [
            'sub_mch_id' => $sub_mch_id,
            'wxa_appid'  => $wxa_appid
        ];
        $this->httpPost("/card/giftcard/pay/submch/bind?access_token={$this->accessToken}", $params);
    }
}
