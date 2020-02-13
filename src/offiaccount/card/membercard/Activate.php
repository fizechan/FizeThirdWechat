<?php


namespace fize\third\wechat\offiaccount\card\membercard;

use fize\third\wechat\Offiaccount;

/**
 * 开卡
 */
class Activate extends Offiaccount
{
    /**
     * 获取开卡插件参数
     * @param string $card_id 卡券ID
     * @param string $outer_str 渠道值
     * @return string|false 返回的url，内含调用开卡插件所需的参数
     */
    public function geturl($card_id, $outer_str = null)
    {
        $params = [
            'card_id' => $card_id,
            'outer_str' => $outer_str
        ];
        $json = $this->httpPost("/card/membercard/activate/geturl?access_token={$this->accessToken}", $params);
        if (!$json) {
            return false;
        }
        return $json['url'];
    }
}
