<?php


namespace Fize\Third\Wechat\Api\Message\Mass;

use Fize\Third\Wechat\Api;

/**
 * 群发速度
 */
class Speed extends Api
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
        $this->httpPost("/message/mass/speed/set?access_token={$this->accessToken}", $params);
    }
}
