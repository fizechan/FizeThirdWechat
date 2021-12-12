<?php


namespace Fize\Third\Wechat\Api;

use Fize\Third\Wechat\ApiAbstract;

/**
 * 回调
 */
class Callback extends ApiAbstract
{

    /**
     * 监测动作：做域名解析
     */
    const ACTION_DNS = 'dns';

    /**
     * 监测动作：做ping检测
     */
    const ACTION_PING = 'ping';

    /**
     * 监测动作：dns和ping都做
     */
    const ACTION_ALL = 'all';

    /**
     * 指定运营商：电信出口
     */
    const CHECK_OPERATOR_CHINANET = 'CHINANET';

    /**
     * 指定运营商：联通出口
     */
    const CHECK_OPERATOR_UNICOM = 'UNICOM';

    /**
     * 指定运营商：腾讯自建出口
     */
    const CHECK_OPERATOR_CAP = 'CAP';

    /**
     * 指定运营商：根据ip来选择运营商
     */
    const CHECK_OPERATOR_DEFAULT = 'DEFAULT';

    /**
     * 网络检测
     * @param string $action         执行的检测动作
     * @param string $check_operator 指定平台从某个运营商进行检测
     * @return array
     * @see https://developers.weixin.qq.com/doc/offiaccount/Basic_Information/Network_Detection.html
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
