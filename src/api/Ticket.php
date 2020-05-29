<?php

namespace fize\third\wechat\api;

use fize\third\wechat\Api;

/**
 * 临时票据
 */
class Ticket extends Api
{

    /**
     * 票据类型：微信卡券
     */
    const TICKET_TYPE_WX_CARD = 'wx_card';

    /**
     * 获取临时票据
     * @param string $type 类型
     * @return array
     */
    public function getticket($type)
    {
        return $this->httpGet("/ticket/getticket?access_token={$this->accessToken}&type={$type}");
    }
}
