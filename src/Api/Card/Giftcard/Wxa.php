<?php


namespace Fize\Third\Wechat\Api\Card\Giftcard;

use Fize\Third\Wechat\Api;

/**
 * 小程序
 */
class Wxa extends Api
{

    /**
     * 上传小程序代码
     * @param string $wxa_appid 小程序APPID
     * @param string $page_id 页面ID
     */
    public function set($wxa_appid, $page_id)
    {
        $params = [
            'wxa_appid' => $wxa_appid,
            'page_id'   => $page_id
        ];
        $this->httpPost("/card/giftcard/wxa/set?access_token={$this->accessToken}", $params);
    }
}
