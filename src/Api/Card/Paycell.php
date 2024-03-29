<?php


namespace Fize\Third\Wechat\Api\Card;

use Fize\Third\Wechat\Api;

/**
 * 买单
 */
class Paycell extends Api
{

    /**
     * 设置买单
     * @param string $card_id 卡券ID
     * @param bool $is_open 是否开启买单功能
     */
    public function set($card_id, $is_open)
    {
        $params = [
            'card_id' => $card_id,
            'is_open' => $is_open
        ];
        $this->httpPost("/card/paycell/set?access_token={$this->accessToken}", $params);
    }
}
