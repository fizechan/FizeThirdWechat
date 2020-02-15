<?php


namespace fize\third\wechat\api\card;

use fize\third\wechat\Api;

/**
 * 飞机票
 */
class Boardingpass extends Api
{

    /**
     * 更新飞机票信息
     * @param string $code 卡券Code码
     * @param string $etkt_bnr 电子客票号
     * @param string $class 舱等
     * @param string $card_id 卡券ID
     * @param string $qrcode_data 二维码数据
     * @param string $seat 座位号
     * @param bool $is_cancel 是否取消值机
     */
    public function checkin($code, $etkt_bnr, $class, $card_id = null, $qrcode_data = null, $seat = null, $is_cancel = null)
    {
        $params = [
            'code'     => $code,
            'etkt_bnr' => $etkt_bnr,
            'class'    => $class,
        ];
        if (!is_null($card_id)) {
            $params['card_id'] = $card_id;
        }
        if (!is_null($qrcode_data)) {
            $params['qrcode_data'] = $qrcode_data;
        }
        if (!is_null($seat)) {
            $params['seat'] = $seat;
        }
        if (!is_null($is_cancel)) {
            $params['is_cancel'] = $is_cancel;
        }
        $this->httpPost("/card/boardingpass/checkin?access_token={$this->accessToken}", $params);
    }
}
