<?php


namespace fize\third\wechat\api\bizwifi;

use fize\third\wechat\Api;

/**
 * 扫码联网
 */
class Qrcode extends Api
{

    /**
     * 获取二维码
     * @param string $shop_id 门店ID
     * @param string $ssid 无线SSID
     * @param int $img_id 物料样式编号
     * @return array
     */
    public function get($shop_id, $ssid, $img_id)
    {
        $params =[
            'shop_id' => $shop_id,
            'ssid' => $ssid,
            'img_id' => $img_id
        ];
        return $this->httpPost("/bizwifi/qrcode/get?access_token={$this->accessToken}", $params);
    }
}
