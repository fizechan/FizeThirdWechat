<?php


namespace fize\third\wechat\api\bizwifi;

use fize\third\wechat\Api;

/**
 * 欢迎首页
 */
class Homepage extends Api
{

    /**
     * 设置欢迎首页
     * @param string $shop_id 门店ID
     * @param string $template_id 关联小程序
     * @param array $struct 跳转小程序原始id
     * @return array
     */
    public function set($shop_id, $template_id, $struct = null)
    {
        $params = [
            'shop_id' => $shop_id,
            'template_id' => $template_id
        ];
        if (!is_null($struct)) {
            $params['struct'] = $struct;
        }
        return $this->httpPost("/bizwifi/homepage/set?access_token={$this->accessToken}", $params);
    }
}
