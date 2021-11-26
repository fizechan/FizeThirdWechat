<?php


namespace Fize\Third\Wechat\Api\Card\Invoice;

use Fize\Third\Wechat\Api;

/**
 * 开票信息
 */
class Setbizattr extends Api
{
    /**
     * 设置支付后开票信息
     *
     * 关联商户号与开票平台
     * @param string $mchid 微信支付商户号
     * @param string $s_pappid 开票平台ID
     */
    public function setPayMch($mchid, $s_pappid)
    {
        $params = [
            'paymch_info' => [
                'mchid'    => $mchid,
                's_pappid' => $s_pappid
            ]
        ];
        $this->httpPost("/card/invoice/setbizattr?action=set_pay_mch&access_token={$this->accessToken}", $params);
    }

    /**
     * 查询支付后开票信息
     *
     * 查询商户号与开票平台关联情况
     * @return array
     */
    public function getPayMch()
    {
        $result = $this->httpPost("/card/invoice/setbizattr?action=get_pay_mch&access_token={$this->accessToken}", '{}', false);
        return $result['paymch_info'];
    }

    /**
     * 设置授权页字段信息
     * @param array $user_field 授权页个人发票字段
     * @param array $biz_field 授权页单位发票字段
     */
    public function setAuthField(array $user_field, array $biz_field)
    {
        $params = [
            'auth_field' => [
                'user_field' => $user_field,
                'biz_field'  => $biz_field
            ]
        ];
        $this->httpPost("/card/invoice/setbizattr?action=set_auth_field&access_token={$this->accessToken}", $params);
    }

    /**
     * 查询授权页字段信息
     * @return array
     */
    public function getAuthField()
    {
        $result = $this->httpPost("/card/invoice/setbizattr?action=get_auth_field&access_token={$this->accessToken}", '{}', false);
        return $result['auth_field'];
    }

    /**
     * 设置商户联系方式
     * @param string $phone 联系电话
     * @param int $time_out 开票超时时间
     * @return array
     */
    public function setContact($phone, $time_out)
    {
        $params = [
            'contact' => [
                'phone' => $phone,
                'time_out' => $time_out
            ]
        ];
        return $this->httpPost("/card/invoice/setbizattr?action=set_contact&access_token={$this->accessToken}", $params);
    }

    /**
     * 查询商户联系方式
     * @return array
     */
    public function getContact()
    {
        return $this->httpPost("/card/invoice/setbizattr?action=get_contact&access_token={$this->accessToken}", '{}', false);
    }
}
