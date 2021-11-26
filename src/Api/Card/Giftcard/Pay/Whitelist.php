<?php


namespace Fize\Third\Wechat\Api\Card\Giftcard\Pay;

use Fize\Third\Wechat\Api;

/**
 * 白名单
 */
class Whitelist extends Api
{

    /**
     * 申请微信支付礼品卡权限
     * @param string $sub_mch_id 微信支付子商户号
     * @return array
     */
    public function add($sub_mch_id)
    {
        $params = [
            'sub_mch_id' => $sub_mch_id
        ];
        return $this->httpPost("/card/giftcard/pay/whitelist/add?access_token={$this->accessToken}", $params);
    }
}
