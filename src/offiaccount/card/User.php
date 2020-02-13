<?php


namespace fize\third\wechat\offiaccount\card;

use fize\third\wechat\Offiaccount;

/**
 * 卡券用户
 */
class User extends Offiaccount
{

    /**
     * 获取用户已领取卡券
     * @param string $openid 需要查询的用户openid
     * @param string $card_id 卡券ID。不填写时默认查询当前appid下的卡券
     * @return bool|mixed
     */
    public function getcardlist($openid, $card_id = null)
    {
        $params = [
            'openid' => $openid
        ];
        if (!is_null($card_id)) {
            $params['card_id'] = $card_id;
        }
        return $this->httpPost("/card/user/getcardlist?access_token={$this->accessToken}", $params);
    }
}
