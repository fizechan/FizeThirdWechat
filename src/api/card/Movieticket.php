<?php


namespace fize\third\wechat\api\card;

use fize\third\wechat\Api;

/**
 * 电影票
 */
class Movieticket extends Api
{
    /**
     * 更新电影票
     * @param string $code 卡券Code码
     * @param string $ticket_class 电影票的类别，如2D、3D
     * @param int $show_time 电影的放映时间戳
     * @param int $duration 放映时长
     * @param string $card_id 卡券ID
     * @param string $screening_room 影厅
     * @param string $seat_number 座位号
     */
    public function updateuser($code, $ticket_class, $show_time, $duration, $card_id = null, $screening_room = null, $seat_number = null)
    {
        $params = [
            'code'         => $code,
            'ticket_class' => $ticket_class,
            'show_time'    => $show_time,
            'duration'     => $duration,
        ];
        if (!is_null($card_id)) {
            $params['card_id'] = $card_id;
        }
        if (!is_null($screening_room)) {
            $params['screening_room'] = $screening_room;
        }
        if (!is_null($seat_number)) {
            $params['seat_number'] = $seat_number;
        }
        $this->httpPost("/card/movieticket/updateuser?access_token={$this->accessToken}", $params);
    }
}
