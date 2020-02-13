<?php


namespace fize\third\wechat\offiaccount\card\giftcard;


use fize\third\wechat\Offiaccount;

/**
 * 订单
 */
class Order extends Offiaccount
{

    /**
     * 查询-单个礼品卡订单信息
     * @param string $order_id 礼品卡订单号
     * @return array|false 返回订单结构体，失败时返回false
     */
    public function get($order_id)
    {
        $params = [
            'order_id' => $order_id,
        ];
        $json = $this->httpPost("/card/giftcard/order/get?access_token={$this->accessToken}", $params);
        if (!$json) {
            return false;
        }
        return $json['order'];
    }

    /**
     * 查询-批量查询礼品卡订单信息
     * @param int $begin_time 查询的时间起点，十位时间戳
     * @param int $end_time 查询的时间终点，十位时间戳
     * @param int $count 查询订单的数量
     * @param int $offset 查询的订单偏移量
     * @param string $sort_type 填"ASC" / "DESC"，表示对订单创建时间进行“升 / 降”排序
     * @return array|false
     */
    public function batchget($begin_time, $end_time, $count, $offset = 0, $sort_type = 'ASC')
    {
        $params = [
            'begin_time' => $begin_time,
            'end_time' => $end_time,
            'count' => $count,
            'offset' => $offset,
            'sort_type' => $sort_type
        ];
        return $this->httpPost("/card/giftcard/order/batchget?access_token={$this->accessToken}", $params);
    }

    /**
     * 退款
     * @param string $order_id 订单id
     * @return bool
     */
    public function refund($order_id)
    {
        $params = [
            'order_id' => $order_id
        ];
        $result = $this->httpPost("/card/giftcard/order/refund?access_token={$this->accessToken}", $params);
        return $result ? true : false;
    }
}
