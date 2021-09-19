<?php


namespace fize\third\wechat\api\bizwifi;

use fize\third\wechat\ApiAbstract;

/**
 * 开放插件
 */
class Openplugin extends ApiAbstract
{

    /**
     * 第三方平台获取开插件wifi_token
     * @param string $callback_url 回调URL
     * @return array
     */
    public function token(string $callback_url): array
    {
        $params = [
            'callback_url' => $callback_url
        ];
        return $this->httpPost("/bizwifi/openplugin/token?access_token=$this->accessToken", $params);
    }
}
