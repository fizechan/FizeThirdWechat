<?php


namespace fize\third\wechat\api\card;

use fize\third\wechat\Api;

/**
 * 门店小程序卡券
 */
class Storewxa extends Api
{

    /**
     * 获取门店小程序配置的卡券
     * @param $poi_id
     * @return array
     */
    public function get($poi_id)
    {
        $params = [
            'poi_id' => $poi_id
        ];
        return $this->httpPost("card/storewxa/get?access_token={$this->accessToken}", $params);
    }

    /**
     * 设置门店小程序配置的卡券
     * @param $poi_id
     * @param $card_id
     * @return array
     */
    public function set($poi_id, $card_id)
    {
        $params = [
            'poi_id' => $poi_id,
            'card_id' => $card_id
        ];
        return $this->httpPost("card/storewxa/set?access_token={$this->accessToken}", $params);
    }
}
