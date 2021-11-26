<?php


namespace Fize\Third\Wechat\Api\Merchant;

use Fize\Third\Wechat\Api;

/**
 * 订单管理
 */
class Order extends Api
{

    /**
     * 根据订单ID获取订单详情
     * @param string $order_id 订单ID
     * @return array
     */
    public function getbyid($order_id)
    {
        $params = [
            'order_id' => $order_id
        ];
        return $this->httpPost("/merchant/order/getbyid?access_token={$this->accessToken}", $params);
    }

    /**
     * 根据订单状态/创建时间获取订单详情
     * @param int $status 订单状态
     * @param int $begintime 订单创建时间起始时间
     * @param int $endtime 订单创建时间终止时间
     * @return array
     */
    public function getbyfilter($status = null, $begintime = null, $endtime = null)
    {
        $params = [];
        if (!is_null($status)) {
            $params['status'] = $status;
        }
        if (!is_null($begintime)) {
            $params['begintime'] = $begintime;
        }
        if (!is_null($endtime)) {
            $params['endtime'] = $endtime;
        }
        return $this->httpPost("/merchant/order/getbyfilter?access_token={$this->accessToken}", $params);
    }

    /**
     * 设置订单发货信息
     * @param string $order_id 订单ID
     * @param string $delivery_track_no 运单ID
     * @param string $delivery_company 物流公司ID
     * @return array
     */
    public function setdelivery($order_id, $delivery_track_no = null, $delivery_company = null)
    {
        $params = [
            'order_id' => $order_id
        ];
        if (!is_null($delivery_track_no)) {
            $params['need_delivery'] = 1;
            $params['delivery_track_no'] = $delivery_track_no;
        }
        if (!is_null($delivery_company)) {
            $params['is_others'] = 1;
            $params['delivery_company'] = $delivery_company;
        }
        return $this->httpPost("/merchant/order/setdelivery?access_token={$this->accessToken}", $params);
    }

    /**
     * 关闭订单
     * @param string $order_id 订单ID
     * @return bool
     */
    public function close($order_id)
    {
        $params = [
            'order_id' => $order_id
        ];
        return $this->httpPost("/merchant/order/setdelivery?access_token={$this->accessToken}", $params);
    }
}
