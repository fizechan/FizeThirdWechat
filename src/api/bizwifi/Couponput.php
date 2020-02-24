<?php


namespace fize\third\wechat\api\bizwifi;

use fize\third\wechat\Api;

/**
 * 卡券投放
 */
class Couponput extends Api
{

    /**
     * 设置门店卡券投放信息
     * @param int $shop_id 门店ID
     * @param string $card_id 卡券ID
     * @param string $card_describe 卡券描述
     * @param int $start_time 卡券投放开始时间
     * @param int $end_time 卡券投放结束时间
     * @return array
     */
    public function set($shop_id, $card_id, $card_describe, $start_time, $end_time)
    {
        $params = [
            'shop_id' => $shop_id,
            'card_id' => $card_id,
            'card_describe' => $card_describe,
            'start_time' => $start_time,
            'end_time' => $end_time
        ];
        return $this->httpPost("/bizwifi/couponput/set?access_token={$this->accessToken}", $params);
    }

    /**
     * 查询门店卡券投放信息
     * @param int $shop_id 门店ID
     * @return array
     */
    public function get($shop_id)
    {
        $params = [
            'shop_id' => $shop_id
        ];
        return $this->httpPost("/bizwifi/couponput/get?access_token={$this->accessToken}", $params);
    }
}
