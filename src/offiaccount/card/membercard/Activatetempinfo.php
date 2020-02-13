<?php


namespace fize\third\wechat\offiaccount\card\membercard;

use fize\third\wechat\Offiaccount;

/**
 * 开卡信息
 */
class Activatetempinfo extends Offiaccount
{

    /**
     * 获取用户开卡时提交的信息
     * @param string $activate_ticket 跳转型开卡组件开卡后回调中的激活票据，可以用来获取用户开卡资料
     * @return array|false
     */
    public function get($activate_ticket)
    {
        $params = [
            'activate_ticket' => $activate_ticket,
        ];
        $json = $this->httpPost("/card/membercard/activatetempinfo/get?access_token={$this->accessToken}", $params);
        if (!$json) {
            return false;
        }
        return $json['info'];
    }
}
