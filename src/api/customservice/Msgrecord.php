<?php


namespace fize\third\wechat\api\customservice;

use fize\third\wechat\Api;

/**
 * 聊天记录
 */
class Msgrecord extends Api
{

    /**
     * 获取聊天记录
     * @param int $starttime 起始时间
     * @param int $endtime 结束时间
     * @param int $msgid 消息id顺序从小到大，从1开始
     * @param int $number 每次获取条数
     * @return array
     */
    public function getmsglist($starttime, $endtime, $msgid, $number)
    {
        $params = [
            'starttime' => $starttime,
            'endtime'   => $endtime,
            'msgid'     => $msgid,
            'number'    => $number
        ];
        return $this->httpPost("/customservice/msgrecord/getmsglist?access_token={$this->accessToken}", $params);
    }
}
