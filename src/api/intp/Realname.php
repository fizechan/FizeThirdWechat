<?php


namespace fize\third\wechat\api\intp;

use fize\third\wechat\Api;

/**
 * 用户信息
 */
class Realname extends Api
{

    /**
     * 获取授权链接
     * @param string $redirect_url 用户授权完成后回跳的url
     * @return array
     */
    public function getauthurl($redirect_url)
    {
        $params = [
            'redirect_url' => $redirect_url
        ];
        return $this->httpPost("/intp/realname/getauthurl?access_token={$this->accessToken}", $params);
    }
}
