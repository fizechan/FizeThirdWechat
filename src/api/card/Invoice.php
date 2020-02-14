<?php


namespace fize\third\wechat\offiaccount\card;

use fize\third\wechat\Offiaccount;

/**
 * 发票
 */
class Invoice extends Offiaccount
{

    /**
     * 查询开票信息
     * @param string $order_id 发票order_id
     * @param string $s_appid 发票平台的身份id
     * @return array|false
     */
    public function getauthdata($order_id, $s_appid)
    {
        $params = [
            'order_id' => $order_id,
            's_appid' => $s_appid
        ];
        return $this->httpPost("/card/invoice/getauthdata?access_token={$this->accessToken}", $params);
    }
}
