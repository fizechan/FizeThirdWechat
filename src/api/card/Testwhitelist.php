<?php


namespace fize\third\wechat\api\card;

use fize\third\wechat\Api;

/**
 * 测试白名单
 */
class Testwhitelist extends Api
{

    /**
     * 设置测试白名单
     * @param string|array $openid 测试的openid
     * @param string|array $username 测试的微信号
     */
    public function set($openid = null, $username = null)
    {
        $params = [];
        if (!is_null($openid)) {
            if (is_string($openid)) {
                $openid = [$openid];
            }
            $params['openid'] = $openid;
        }
        if (!is_null($username)) {
            if (is_string($username)) {
                $username = [$username];
            }
            $params['username'] = $username;
        }
        $this->httpPost("/card/testwhitelist/set?access_token={$this->accessToken}", $params);
    }
}
