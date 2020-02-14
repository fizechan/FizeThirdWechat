<?php


namespace fize\third\wechat\offiaccount\card;


use fize\third\wechat\Offiaccount;

/**
 * 自助核销
 */
class Selfconsumecell extends Offiaccount
{

    /**
     * 设置自助核销
     * @param string $card_id 卡券ID
     * @param bool $is_open 是否开启自助核销功能
     * @param bool $need_verify_cod 用户核销时是否需要输入验证码
     * @param bool $need_remark_amount 用户核销时是否需要备注核销金额
     * @return bool
     */
    public function set($card_id, $is_open, $need_verify_cod = false, $need_remark_amount = false)
    {
        $params = [
            'card_id'            => $card_id,
            'is_open'            => $is_open,
            'need_verify_cod'    => $need_verify_cod,
            'need_remark_amount' => $need_remark_amount
        ];
        $result = $this->httpPost("/card/selfconsumecell/set?access_token={$this->accessToken}", $params);
        return $result ? true : false;
    }
}
