<?php


namespace fize\third\wechat\offiaccount\card;

use fize\third\wechat\Offiaccount;

/**
 * 图文消息
 */
class Mpnews extends Offiaccount
{
    /**
     * 获取卡券嵌入图文消息的标准格式代码
     * @param string $card_id 卡券ID
     * @return string|false
     */
    public function gethtml($card_id)
    {
        $params = [
            'card_id' => $card_id
        ];
        $json = $this->httpPost("/card/mpnews/gethtml?access_token={$this->accessToken}", $params);
        if (!$json) {
            return false;
        }
        return $json['content'];
    }
}
