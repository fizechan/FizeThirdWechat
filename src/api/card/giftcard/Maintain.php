<?php


namespace fize\third\wechat\api\card\giftcard;

use fize\third\wechat\Api;

/**
 * 礼品卡货架维护
 */
class Maintain extends Api
{

    /**
     * 下架-礼品卡货架
     * @param string $page_id 需要下架的page_id
     * @param bool $all 是否将该商户下所有的货架设置为下架
     * @param bool $maintain 为true表示下架
     */
    public function set($page_id = null, $all = null, $maintain = true)
    {
        $params = [
            'maintain' => $maintain
        ];
        if (!is_null($page_id)) {
            $params['page_id'] = $page_id;
        }
        if (!is_null($all)) {
            $params['all'] = $all;
        }
        $this->httpPost("/card/giftcard/maintain/set?access_token={$this->accessToken}", $params);
    }
}
