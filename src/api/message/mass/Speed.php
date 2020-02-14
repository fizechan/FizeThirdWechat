<?php


namespace fize\third\wechat\offiaccount\message\mass;

use fize\third\wechat\Offiaccount;

/**
 * 群发速度
 */
class Speed extends Offiaccount
{

    /**
     * 获取群发速度
     * @return array
     */
    public function get()
    {
        return $this->httpGet("message/mass/speed/get?access_token={$this->accessToken}");
    }

    /**
     * 设置群发速度
     * @param int $speed 速度
     */
    public function set($speed)
    {
        $params = [
            'speed' => $speed
        ];
        $result = $this->httpPost("/message/mass/speed/set?access_token={$this->accessToken}", $params);
    }
}
