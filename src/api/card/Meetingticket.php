<?php


namespace fize\third\wechat\offiaccount\card;

use fize\third\wechat\Offiaccount;

/**
 * 会议门票
 */
class Meetingticket extends Offiaccount
{
    /**
     * 更新会议门票
     * @param string $code 卡券Code码
     * @param string $zone 区域
     * @param string $entrance 入口
     * @param string $seat_number 座位号
     * @param string $card_id 卡券ID
     * @param int $begin_time 开场时间戳
     * @param int $end_time 结束时间戳
     * @return bool
     */
    public function updateuser($code, $zone, $entrance, $seat_number, $card_id = null, $begin_time = null, $end_time = null)
    {
        $params = [
            'code' => $code,
            'zone' => $zone,
            'entrance' => $entrance,
            'seat_number' => $seat_number,
        ];
        if (!is_null($card_id)) {
            $params['card_id'] = $card_id;
        }
        if (!is_null($begin_time)) {
            $params['begin_time'] = $begin_time;
        }
        if (!is_null($end_time)) {
            $params['end_time'] = $end_time;
        }
        $result = $this->httpPost("/card/meetingticket/updateuser?access_token={$this->accessToken}", $params);
        return $result ? true : false;
    }
}
