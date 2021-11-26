<?php


namespace Fize\Third\Wechat\Api\Bizwifi;

use Fize\Third\Wechat\Api;

/**
 * portal型设备
 */
class Apportal extends Api
{

    /**
     * 添加portal型设备
     * @param string $shop_id 门店ID
     * @param string $ssid 无线SSID
     * @param bool $reset 重置secretkey
     * @return array
     */
    public function register($shop_id, $ssid, $reset = null)
    {
        $params = [
            'shop_id' => $shop_id,
            'ssid' => $ssid
        ];
        if (!is_null($reset)) {
            $params['reset'] = $reset;
        }
        return $this->httpPost("/bizwifi/apportal/register?access_token={$this->accessToken}", $params);
    }
}
