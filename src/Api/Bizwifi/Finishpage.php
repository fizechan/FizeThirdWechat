<?php


namespace Fize\Third\Wechat\Api\Bizwifi;

use Fize\Third\Wechat\Api;

/**
 * 联网完成页
 */
class Finishpage extends Api
{

    /**
     * 设置联网完成页
     * @param string $shop_name 门店名称
     * @param string $finishpage_url 连网完成页URL
     * @param string $wxa_user_name 连网完成页跳转小程序原始id
     * @param string $wxa_path 连网完成页跳转小程序路径
     * @param int $finishpage_type 连网完成页跳转类型
     * @return array
     */
    public function set($shop_name, $finishpage_url = null, $wxa_user_name = null, $wxa_path = null, $finishpage_type = null)
    {
        $params = [
            'shop_name' => $shop_name
        ];
        if (is_null($finishpage_url)) {
            $params['finishpage_url'] = $finishpage_url;
        }
        if (is_null($wxa_user_name)) {
            $params['wxa_user_name'] = $wxa_user_name;
        }
        if (is_null($wxa_path)) {
            $params['wxa_path'] = $wxa_path;
        }
        if (is_null($finishpage_type)) {
            $params['finishpage_type'] = $finishpage_type;
        }
        return $this->httpPost("/bizwifi/finishpage/set?access_token={$this->accessToken}", $params);
    }
}
