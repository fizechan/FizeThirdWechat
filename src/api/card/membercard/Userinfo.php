<?php


namespace fize\third\wechat\api\card\membercard;

use fize\third\wechat\Api;

/**
 * 会员信息
 */
class Userinfo extends Api
{

    /**
     * 拉取会员信息
     * @param string $card_id 卡券ID
     * @param string $code Code码
     * @return array
     */
    public function get($card_id, $code)
    {
        $params = [
            'card_id' => $card_id,
            'code'    => $code
        ];
        return $this->httpPost("/card/membercard/userinfo/get?access_token={$this->accessToken}", $params);
    }
}
