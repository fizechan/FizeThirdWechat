<?php


namespace Fize\Third\Wechat\Api\Nontax;

use Fize\Third\Wechat\Api;

/**
 * 非税车主平台
 */
class Vehicle extends Api
{

    /**
     * 用户状态查询
     * @param array $params 参数
     * @return array
     */
    public function querystate(array $params)
    {
        return $this->httpPost("/nontax/vehicle/querystate?access_token={$this->accessToken}", $params);
    }

    /**
     * 用户入场通知
     * @param string $appid appid
     * @param string $region_code 行政区划代码
     * @param string $rade_scene 委托代扣的交易场景值
     * @param array $scene_info 场景信息值
     * @param string $bank_id 银行id
     * @param string $bank_account 清分银行帐号
     * @param string $mch_id 指定资金结算到mch_id
     * @return array
     */
    public function entrancenotify($appid, $region_code, $rade_scene, array $scene_info, $bank_id = null, $bank_account = null, $mch_id = null)
    {
        $params = [
            'appid' => $appid,
            'region_code' => $region_code,
            'rade_scene' => $rade_scene,
            'scene_info' => $scene_info
        ];
        if (!is_null($bank_id)) {
            $params['bank_id'] = $bank_id;
        }
        if (!is_null($bank_account)) {
            $params['bank_account'] = $bank_account;
        }
        if (!is_null($mch_id)) {
            $params['mch_id'] = $mch_id;
        }
        return $this->httpPost("/nontax/vehicle/entrancenotify?access_token={$this->accessToken}", $params);
    }

    /**
     * 申请扣款
     * @param array $params 参数
     * @return array
     */
    public function payapply(array $params)
    {
        return $this->httpPost("/nontax/vehicle/payapply?access_token={$this->accessToken}", $params);
    }
}
