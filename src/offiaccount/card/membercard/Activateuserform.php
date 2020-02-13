<?php


namespace fize\third\wechat\offiaccount\card\membercard;

use fize\third\wechat\Offiaccount;

/**
 * 开卡字段
 */
class Activateuserform extends Offiaccount
{

    /**
     * 设置开卡字段
     * @param string $card_id 卡券ID
     * @param array $extend 其他字段
     * @return array|false
     */
    public function set($card_id, array $extend = [])
    {
        $params = [
            'card_id' => $card_id
        ];
        $params = array_merge($params, $extend);
        return $this->httpPost("/card/membercard/activateuserform/set?access_token={$this->accessToken}", $params);
    }
}
