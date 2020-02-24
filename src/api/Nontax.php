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
     * @param string $s_pappid 财政局id
     * @param string $order_id 订单id
     * @param int $money 订单金额，以分为单位
     * @param int $timestamp 时间戳
     * @param string $source 开票来源
     * @param string $ticket Api_ticket
     * @param string $redirect_url 授权成功后跳转页面
     * @return array
     */
    public function getbillauthurl($s_pappid, $order_id, $money, $timestamp, $source, $ticket, $redirect_url = null)
    {
        $params = [
            's_pappid' => $s_pappid,
            'order_id' => $order_id,
            'money' => $money,
            'timestamp' => $timestamp,
            'source' => $source,
            'ticket' => $ticket
        ];
        if (!is_null($redirect_url)) {
            $params['redirect_url'] = $redirect_url;
        }
        return $this->httpPost("/nontax/getbillauthurl?access_token={$this->accessToken}", $params);
    }

    /**
     * 创建财政电子票据
     * @param string $logo_url 财政局LOGO
     * @param string $payee 收款方（开票方）全称
     * @return array
     */
    public function createbillcard($logo_url, $payee)
    {
        $params = [
            'invoice_info' => [
                'base_info' => [
                    'logo_url' => $logo_url
                ],
                'payee' => $payee
            ]
        ];
        return $this->httpPost("/nontax/createbillcard?access_token={$this->accessToken}", $params);
    }

    /**
     * 将财政电子票据添加到用户微信卡包
     * @param string $order_id 财政电子票据order_id
     * @param string $card_id 财政电子票据card_id
     * @param string $appid 该订单号授权时使用的appid
     * @param array $card_ext 财政电子票据具体内容
     * @return array
     */
    public function insertbill($order_id, $card_id, $appid, array $card_ext)
    {
        $params = [
            'order_id' => $order_id,
            'card_id' => $card_id,
            'appid' => $appid,
            'card_ext' => $card_ext
        ];
        return $this->httpPost("/nontax/insertbill?access_token={$this->accessToken}", $params);
    }
}
