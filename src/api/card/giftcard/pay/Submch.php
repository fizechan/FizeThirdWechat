<?php


namespace fize\third\wechat\offiaccount\card\giftcard\pay;

use fize\third\wechat\Offiaccount;

/**
 * 小程序
 */
class Submch extends Offiaccount
{

    /**
     * 绑定商户号到礼品卡小程序
     * @param string $sub_mch_id 商户号
     * @param string $wxa_appid 小程序APPID
     * @return bool
     */
    public function bind($sub_mch_id, $wxa_appid)
    {
        $params = [
            'sub_mch_id' => $sub_mch_id,
            'wxa_appid' => $wxa_appid
        ];
        $result = $this->httpPost("/card/giftcard/pay/submch/bind?access_token={$this->accessToken}", $params);
        return $result ? true : false;
    }
}
