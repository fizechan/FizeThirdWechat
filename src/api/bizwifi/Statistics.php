<?php


namespace fize\third\wechat\api\bizwifi;

use fize\third\wechat\Api;

/**
 * 数据统计
 */
class Statistics extends Api
{

    /**
     * 数据统计
     * @param string $begin_date 起始日期时间
     * @param string $end_date 结束日期时间
     * @param string $shop_id 按门店ID搜索，-1为总统计
     * @return array
     */
    public function list($begin_date, $end_date, $shop_id = null)
    {
        $params = [
            'begin_date' => $begin_date,
            'end_date' => $end_date
        ];
        if (!is_null($shop_id)) {
            $params['shop_id'] = $shop_id;
        }
        return $this->httpPost("/bizwifi/statistics/list?access_token={$this->accessToken}", $params);
    }
}
