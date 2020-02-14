<?php


namespace fize\third\wechat\offiaccount\card\giftcard\pay;

use fize\third\wechat\Offiaccount;

/**
 * 白名单
 */
class Whitelist extends Offiaccount
{

    /**
     * 申请微信支付礼品卡权限
     * @param string $sub_mch_id 微信支付子商户号
     * @return array|false
     */
    public function add($sub_mch_id)
    {
        $params = [
            'sub_mch_id' => $sub_mch_id
        ];
        return $this->httpPost("/card/giftcard/pay/whitelist/add?access_token={$this->accessToken}", $params);
    }
}
