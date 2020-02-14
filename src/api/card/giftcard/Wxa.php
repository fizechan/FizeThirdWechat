<?php


namespace fize\third\wechat\offiaccount\card\giftcard;

use fize\third\wechat\Offiaccount;

/**
 * 小程序
 */
class Wxa extends Offiaccount
{

    /**
     * 上传小程序代码
     * @param string $wxa_appid 小程序APPID
     * @param string $page_id 页面ID
     * @return bool
     */
    public function set($wxa_appid, $page_id)
    {
        $params = [
            'wxa_appid' => $wxa_appid,
            'page_id' => $page_id
        ];
        $result = $this->httpPost("/card/giftcard/wxa/set?access_token={$this->accessToken}", $params);
        return $result ? true : false;
    }
}
