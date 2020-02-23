<?php


namespace fize\third\wechat\api\shakearound;

use fize\third\wechat\Api;

/**
 * 数据统计
 */
class Statistics extends Api
{

    /**
     * 设备维度数据统计
     * @param array $device_identifier 设备ID
     * @param int $begin_date 起始日期时间戳
     * @param int $end_date 结束日期时间戳
     * @return array|string
     */
    public function device(array $device_identifier, $begin_date, $end_date)
    {
        $params = [
            'device_identifier' => $device_identifier,
            'begin_date' => $begin_date,
            'end_date' => $end_date
        ];
        return $this->httpPost("/shakearound/statistics/device?access_token={$this->accessToken}", $params);
    }

    /**
     * 批量查询设备统计数据
     * @param int $date 查询日期时间戳
     * @param int $page_index 结果页序号
     * @return array
     */
    public function devicelist($date, $page_index)
    {
        $params = [
            'date' => $date,
            'page_index' => $page_index
        ];
        return $this->httpPost("/shakearound/statistics/devicelist?access_token={$this->accessToken}", $params);
    }

    /**
     * 页面维度数据统计
     * @param string $page_id 页面ID
     * @param int $begin_date 起始日期时间戳
     * @param int $end_date 结束日期时间戳
     * @return array
     */
    public function page($page_id, $begin_date, $end_date)
    {
        $params = [
            'page_id' => $page_id,
            'begin_date' => $begin_date,
            'end_date' => $end_date
        ];
        return $this->httpPost("/shakearound/statistics/page?access_token={$this->accessToken}", $params);
    }

    /**
     * 批量查询页面统计数据
     * @param int $date 查询日期时间戳
     * @param int $page_index 结果页序号
     * @return array
     */
    public function pagelist($date, $page_index)
    {
        $params = [
            'date' => $date,
            'page_index' => $page_index
        ];
        return $this->httpPost("/shakearound/statistics/pagelist?access_token={$this->accessToken}", $params);
    }
}
