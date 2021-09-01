<?php


namespace fize\third\wechat\api;

use fize\third\wechat\Api;

/**
 * 回调
 */
class Callback extends Api
{

    const ACTION_DNS = 'dns';

    const ACTION_PING = 'ping';

    const ACTION_ALL = 'all';

    const CHECK_OPERATOR_CHINANET = 'CHINANET';

    const CHECK_OPERATOR_UNICOM = 'UNICOM';

    const CHECK_OPERATOR_CAP = 'CAP';

    const CHECK_OPERATOR_DEFAULT = 'DEFAULT';

    /**
     * 网络检测
     * @param string $action         执行的检测动作
     * @param string $check_operator 指定平台从某个运营商进行检测
     * @return array
     */
    public function check(string $action, string $check_operator): array
    {
        $params = [
            'action'         => $action,
            'check_operator' => $check_operator
        ];
        return $this->httpPost("/callback/check?access_token=$this->accessToken", $params);
    }
}
