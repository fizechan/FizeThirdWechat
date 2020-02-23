<?php


namespace fize\third\wechat\api;

use fize\third\wechat\Api;

/**
 * 回调
 */
class Callback extends Api
{

    /**
     * 网络检测
     * @param string $action 执行的检测动作
     * @param string $check_operator 指定平台从某个运营商进行检测
     * @return mixed
     */
    public function check($action, $check_operator)
    {
        $params = [
            'action'         => $action,
            'check_operator' => $check_operator
        ];
        return $this->httpPost("/callback/check?access_token={$this->accessToken}", $params);
    }
}
