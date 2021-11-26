<?php


namespace Fize\Third\Wechat\Api\Card;

use Fize\Third\Wechat\Api;

/**
 * 图文消息
 */
class Mpnews extends Api
{
    /**
     * 获取卡券嵌入图文消息的标准格式代码
     * @param string $card_id 卡券ID
     * @return string
     */
    public function gethtml($card_id)
    {
        $params = [
            'card_id' => $card_id
        ];
        $result = $this->httpPost("/card/mpnews/gethtml?access_token={$this->accessToken}", $params);
        return $result['content'];
    }
}
