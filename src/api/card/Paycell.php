<?php


namespace fize\third\wechat\offiaccount\card;

use fize\third\wechat\Offiaccount;

/**
 * 买单
 */
class Paycell extends Offiaccount
{

    /**
     * 设置买单
     * @param string $card_id 卡券ID
     * @param bool $is_open 是否开启买单功能
     * @return bool
     */
    public function set($card_id, $is_open)
    {
        $params = [
            'card_id' => $card_id,
            'is_open' => $is_open
        ];
        $result = $this->httpPost("/card/paycell/set?access_token={$this->accessToken}", $params);
        return $result ? true : false;
    }
}
