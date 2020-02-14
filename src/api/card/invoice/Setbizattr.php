<?php


namespace fize\third\wechat\offiaccount\card\invoice;

use fize\third\wechat\Offiaccount;

/**
 * 开票信息
 */
class Setbizattr extends Offiaccount
{
    /**
     * 设置支付后开票信息
     * @param string $mchid 微信支付商户号
     * @param string $s_pappid 开票平台ID
     * @return bool
     */
    public function setPayMch($mchid, $s_pappid)
    {
        $params = [
            'paymch_info' => [
                'mchid' => $mchid,
                's_pappid' => $s_pappid
            ]
        ];
        $result = $this->httpPost("/card/invoice/setbizattr?action=set_pay_mch&access_token={$this->accessToken}", $params);
        return $result ? true : false;
    }

    /**
     * 查询支付后开票信息
     * @return array|false
     */
    public function getPayMch()
    {
        $result = $this->httpPost("/card/invoice/setbizattr?action=get_pay_mch&access_token={$this->accessToken}", '{}', false);
        if (!$result) {
            return false;
        }
        return $result['paymch_info'];
    }

    /**
     * 设置授权页字段信息
     * @param array $user_field 授权页个人发票字段
     * @param array $biz_field 授权页单位发票字段
     * @return bool
     */
    public function setAuthField(array $user_field, array $biz_field)
    {
        $params = [
            'auth_field' => [
                'user_field' => $user_field,
                'biz_field' => $biz_field
            ]
        ];
        $result = $this->httpPost("/card/invoice/setbizattr?action=set_auth_field&access_token={$this->accessToken}", $params);
        return $result ? true : false;
    }

    /**
     * 查询授权页字段信息
     * @return array|false
     */
    public function getAuthField()
    {
        $result = $this->httpPost("/card/invoice/setbizattr?action=get_auth_field&access_token={$this->accessToken}", '{}', false);
        if (!$result) {
            return false;
        }
        return $result['auth_field'];
    }
}
