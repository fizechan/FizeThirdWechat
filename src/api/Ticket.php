<?php


namespace fize\third\wechat\api;

use fize\third\wechat\Api;

/**
 * 临时票据
 */
class Ticket extends Api
{

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
