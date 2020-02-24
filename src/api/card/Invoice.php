<?php


namespace fize\third\wechat\api\card;

use fize\third\wechat\Api;

/**
 * 发票
 */
class Invoice extends Api
{

    /**
     * 查询开票信息
     *
     * 查询授权完成状态
     * @param string $order_id 发票order_id
     * @param string $s_appid 发票平台的身份id
     * @return array
     */
    public function getauthdata($order_id, $s_appid)
    {
        $params = [
            'order_id' => $order_id,
            's_appid'  => $s_appid
        ];
        return $this->httpPost("/card/invoice/getauthdata?access_token={$this->accessToken}", $params);
    }

    /**
     * 获取授权页链接
     * @param string $s_pappid 开票平台在微信的标识号
     * @param string $order_id 订单ID
     * @param int $money 订单金额，以分为单位
     * @param int $timestamp 时间戳
     * @param string $source 开票来源
     * @param string $ticket 临时票据
     * @param int $type 授权类型
     * @param string $redirect_url 授权成功后跳转页面
     * @return array
     */
    public function getauthurl($s_pappid, $order_id, $money, $timestamp, $source, $ticket, $type, $redirect_url = null)
    {
        $params = [
            's_pappid' => $s_pappid,
            'order_id' => $order_id,
            'money' => $money,
            'timestamp' => $timestamp,
            'source' => $source,
            'ticket' => $ticket,
            'type' => $type
        ];
        if (!is_null($redirect_url)) {
            $params['redirect_url'] = $redirect_url;
        }
        return $this->httpPost("/card/invoice/getauthurl?access_token={$this->accessToken}", $params);
    }

    /**
     * 拒绝开票
     * @param string $s_pappid 开票平台在微信上的标识
     * @param string $order_id 订单ID
     * @param string $reason 拒绝开票的原因
     * @param string $url 跳转链接
     * @return array
     */
    public function rejectinsert($s_pappid, $order_id, $reason, $url = null)
    {
        $params = [
            's_pappid' => $s_pappid,
            'order_id' => $order_id,
            'reason' => $reason
        ];
        if (!is_null($url)) {
            $params['url'] = $url;
        }
        return $this->httpPost("/card/invoice/rejectinsert?access_token={$this->accessToken}", $params);
    }

    /**
     * 开具蓝票
     * @param array $params 参数
     * @return array
     */
    public function makeoutinvoice(array $params)
    {
        return $this->httpPost("/card/invoice/makeoutinvoice?access_token={$this->accessToken}", $params);
    }

    /**
     * 发票冲红
     * @param string $wxopenid 用户的openid
     * @param string $fpqqlsh 发票请求流水号
     * @param string $nsrsbh 纳税人识别码
     * @param string $nsrmc 纳税人名称
     * @param string $yfpdm 原发票代码
     * @param string $fphm 原发票号码
     * @return array
     */
    public function clearoutinvoice($wxopenid, $fpqqlsh, $nsrsbh, $nsrmc, $yfpdm, $fphm)
    {
        $params = [
            'wxopenid' => $wxopenid,
            'fpqqlsh' => $fpqqlsh,
            'nsrsbh' => $nsrsbh,
            'nsrmc' => $nsrmc,
            'yfpdm' => $yfpdm,
            'fphm' => $fphm
        ];
        return $this->httpPost("/card/invoice/clearoutinvoice?access_token={$this->accessToken}", $params);
    }

    /**
     * 查询已开发票
     * @param string $fpqqlsh 发票请求流水号
     * @param string $nsrsbh 纳税人识别码
     * @return array
     */
    public function queryinvoceinfo($fpqqlsh, $nsrsbh)
    {
        $params = [
            'fpqqlsh' => $fpqqlsh,
            'nsrsbh' => $nsrsbh
        ];
        return $this->httpPost("/card/invoice/queryinvoceinfo?access_token={$this->accessToken}", $params);
    }

    /**
     * 获取自身的开票平台识别码
     * @return array
     */
    public function seturl()
    {
        return $this->httpPost("/card/invoice/seturl?access_token={$this->accessToken}", '{}', false);
    }

    /**
     * 将电子发票卡券插入用户卡包
     * @param string $order_id 开票的订单号
     * @param string $card_id 发票card_id
     * @param string $appid 单号授权时使用的appid
     * @param array $card_ext 发票具体内容
     * @return array
     */
    public function insert($order_id, $card_id, $appid, array $card_ext)
    {
        $params = [
            'order_id' => $order_id,
            'card_id' => $card_id,
            'appid' => $appid,
            'card_ext' => $card_ext
        ];
        return $this->httpPost("/card/invoice/insert?access_token={$this->accessToken}", $params);
    }

    /**
     * 商户扫描用户的发票抬头二维码
     * @param string $scan_text 扫描后获取的文本
     * @return array
     */
    public function scantitle($scan_text)
    {
        $params = [
            'scan_text' => $scan_text
        ];
        return $this->httpPost("/card/invoice/scantitle?access_token={$this->accessToken}", $params);
    }
}
