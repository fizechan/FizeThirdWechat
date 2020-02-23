<?php


namespace fize\third\wechat\api\shakearound;

use fize\third\wechat\Api;

/**
 * 用户信息
 */
class User extends Api
{

    /**
     * 获取设备信息
     * @param string $ticket 摇周边业务的ticket
     * @param int $need_poi 是否需要返回门店poi_id
     * @return array
     */
    public function getshakeinfo($ticket, $need_poi = null)
    {
        $params = [
            'ticket' => $ticket
        ];
        if (!is_null($need_poi)) {
            $params['need_poi'] = $need_poi;
        }
        return $this->httpPost("/shakearound/user/getshakeinfo?access_token={$this->accessToken}", $params);
    }
}
