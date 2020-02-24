<?php


namespace fize\third\wechat\api\bizwifi;

use fize\third\wechat\Api;

/**
 * 开放插件
 */
class Openplugin extends Api
{

    /**
     * 第三方平台获取开插件wifi_token
     * @param string $callback_url 回调URL
     * @return array
     */
    public function token($callback_url)
    {
        $params = [
            'callback_url' => $callback_url
        ];
        return $this->httpPost("/bizwifi/openplugin/token?access_token={$this->accessToken}", $params);
    }
}
