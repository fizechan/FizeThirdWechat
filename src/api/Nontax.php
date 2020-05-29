<?php


namespace fize\third\wechat\api;

use fize\third\wechat\Api;

/**
 * 非税票据
 */
class Nontax extends Api
{

    /**
     * 获取授权页链接
     * @param string $s_pappid     财政局id
     * @param string $order_id     订单id
     * @param int    $money        订单金额，以分为单位
     * @param int    $timestamp    时间戳
     * @param string $source       开票来源
     * @param string $ticket       Api_ticket
     * @param string $redirect_url 授权成功后跳转页面
     * @return array
     */
    public function getbillauthurl($s_pappid, $order_id, $money, $timestamp, $source, $ticket, $redirect_url = null)
    {
        $params = [
            's_pappid'  => $s_pappid,
            'order_id'  => $order_id,
            'money'     => $money,
            'timestamp' => $timestamp,
            'source'    => $source,
            'ticket'    => $ticket
        ];
        if (!is_null($redirect_url)) {
            $params['redirect_url'] = $redirect_url;
        }
        return $this->httpPost("/nontax/getbillauthurl?access_token={$this->accessToken}", $params);
    }

    /**
     * 创建财政电子票据
     * @param string $logo_url 财政局LOGO
     * @param string $payee    收款方（开票方）全称
     * @return array
     */
    public function createbillcard($logo_url, $payee)
    {
        $params = [
            'invoice_info' => [
                'base_info' => [
                    'logo_url' => $logo_url
                ],
                'payee'     => $payee
            ]
        ];
        return $this->httpPost("/nontax/createbillcard?access_token={$this->accessToken}", $params);
    }

    /**
     * 将财政电子票据添加到用户微信卡包
     * @param string $order_id 财政电子票据order_id
     * @param string $card_id  财政电子票据card_id
     * @param string $appid    该订单号授权时使用的appid
     * @param array  $card_ext 财政电子票据具体内容
     * @return array
     */
    public function insertbill($order_id, $card_id, $appid, array $card_ext)
    {
        $params = [
            'order_id' => $order_id,
            'card_id'  => $card_id,
            'appid'    => $appid,
            'card_ext' => $card_ext
        ];
        return $this->httpPost("/nontax/insertbill?access_token={$this->accessToken}", $params);
    }

    /**
     * 查询应收信息
     * @param string $appid               appid
     * @param int    $service_id          服务id
     * @param string $payment_notice_no   缴费通知书编号
     * @param string $department_code     执收单位编码
     * @param string $region_code         行政区划代码
     * @param string $bank_id             银行id
     * @param int    $payment_notice_type 通知书类型
     * @return array
     */
    public function queryfee($appid, $service_id, $payment_notice_no, $department_code, $region_code, $bank_id = null, $payment_notice_type = null)
    {
        $params = [
            'appid'             => $appid,
            'service_id'        => $service_id,
            'payment_notice_no' => $payment_notice_no,
            'department_code'   => $department_code,
            'region_code'       => $region_code
        ];
        if (!is_null($bank_id)) {
            $params['bank_id'] = $bank_id;
        }
        if (!is_null($payment_notice_type)) {
            $params['payment_notice_type'] = $payment_notice_type;
        }
        return $this->httpPost("/nontax/queryfee?access_token={$this->accessToken}", $params);
    }

    /**
     * 支付下单
     * @param array $params 参数
     * @return array
     */
    public function unifiedorder(array $params)
    {
        return $this->httpPost("/nontax/unifiedorder?access_token={$this->accessToken}", $params);
    }

    /**
     * 查询订单
     * @param string $appid      appid
     * @param int    $service_id 服务id
     * @param string $order_id   订单ID
     * @return array
     */
    public function getorder($appid, $service_id, $order_id)
    {
        $params = [
            'appid'      => $appid,
            'service_id' => $service_id,
            'order_id'   => $order_id
        ];
        return $this->httpPost("/nontax/getorder?access_token={$this->accessToken}", $params);
    }

    /**
     * 申请退款
     * @param string $appid         appid
     * @param string $order_id      订单ID
     * @param string $reason        退款原因
     * @param int    $refund_fee    退款金额（单位是分）
     * @param string $refund_out_id 退款单号
     * @return array
     */
    public function refund($appid, $order_id, $reason, $refund_fee = null, $refund_out_id = null)
    {
        $params = [
            'appid'    => $appid,
            'order_id' => $order_id,
            'reason'   => $reason
        ];
        if (!is_null($refund_fee)) {
            $params['refund_fee'] = $refund_fee;
        }
        if (!is_null($refund_out_id)) {
            $params['refund_out_id'] = $refund_out_id;
        }
        return $this->httpPost("/nontax/refund?access_token={$this->accessToken}", $params);
    }

    /**
     * 下载对帐单
     * @param string $appid     appid
     * @param string $bill_date 对账单日期，格式：20170903
     * @param string $mch_id    商户号
     * @param string $bill_type 返回类型
     * @return array
     */
    public function downloadbill($appid, $bill_date, $mch_id = null, $bill_type = null)
    {
        $params = [
            'appid'     => $appid,
            'bill_date' => $bill_date
        ];
        if (!is_null($mch_id)) {
            $params['mch_id'] = $mch_id;
        }
        if (!is_null($bill_type)) {
            $params['bill_type'] = $bill_type;
        }
        return $this->httpPost("/nontax/downloadbill?access_token={$this->accessToken}", $params);
    }

    /**
     * 通知不一致订单
     * @param string $appid    appid
     * @param string $order_id 订单ID
     * @return array
     */
    public function notifyinconsistentorder($appid, $order_id)
    {
        $params = [
            'appid'    => $appid,
            'order_id' => $order_id
        ];
        return $this->httpPost("/nontax/notifyinconsistentorder?access_token={$this->accessToken}", $params);
    }

    /**
     * 测试支付结果通知
     * @param string $appid   appid
     * @param string $url     接收通知的url
     * @param int    $version 协议版本号
     * @return array
     */
    public function mocknotification($appid, $url, $version)
    {
        $params = [
            'appid'   => $appid,
            'url'     => $url,
            'version' => $version
        ];
        return $this->httpPost("/nontax/mocknotification?access_token={$this->accessToken}", $params);
    }

    /**
     * 测试查询应收信息
     * @param string $appid   appid
     * @param string $url     接收通知的url
     * @param int    $version 协议版本号
     * @return array
     */
    public function mockqueryfee($appid, $url, $version)
    {
        $params = [
            'appid'   => $appid,
            'url'     => $url,
            'version' => $version
        ];
        return $this->httpPost("/nontax/mockqueryfee?access_token={$this->accessToken}", $params);
    }

    /**
     * 提交刷卡支付
     * @param array $params 参数
     * @return array
     */
    public function micropay(array $params)
    {
        return $this->httpPost("/nontax/micropay?access_token={$this->accessToken}", $params);
    }

    /**
     * 查询订单列表
     * @param string $appid             appid
     * @param string $payment_notice_no 缴费通知书编号
     * @param string $department_code   执收单位编码
     * @param string $region_code       行政区划代码
     * @return array|string
     */
    public function getorderlist($appid, $payment_notice_no, $department_code, $region_code)
    {
        $params = [
            'appid'             => $appid,
            'payment_notice_no' => $payment_notice_no,
            'department_code'   => $department_code,
            'region_code'       => $region_code
        ];
        return $this->httpPost("/nontax/getorderlist?access_token={$this->accessToken}", $params);
    }

    /**
     * 获取实名信息
     * @param string $wx_realname_token wx_realname_token参数
     * @return array|string
     */
    public function getrealname($wx_realname_token)
    {
        $params = [
            'wx_realname_token' => $wx_realname_token
        ];
        return $this->httpPost("/nontax/getrealname?access_token={$this->accessToken}", $params);
    }
}
