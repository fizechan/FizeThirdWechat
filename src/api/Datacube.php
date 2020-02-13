<?php


namespace fize\third\wechat\api;


use fize\third\wechat\Api;


/**
 * 数据统计
 */
class DataCube extends Api
{

    /**
     * 获取用户增减数据
     * @param string $begin_date 开始日期
     * @param string $end_date 结束日期
     * @return array|false
     */
    public function getusersummary($begin_date, $end_date)
    {
        return $this->action('getusersummary', $begin_date, $end_date);
    }

    /**
     * 获取累计用户数据
     * @param string $begin_date 开始日期
     * @param string $end_date 结束日期
     * @return array|false
     */
    public function getusercumulate($begin_date, $end_date)
    {
        return $this->action('getusercumulate', $begin_date, $end_date);
    }

    /**
     * 获取图文群发每日数据
     * @param string $begin_date 开始日期
     * @param string $end_date 结束日期
     * @return array|false
     */
    public function getarticlesummary($begin_date, $end_date)
    {
        return $this->action('getarticlesummary', $begin_date, $end_date);
    }

    /**
     * 获取图文群发总数据
     * @param string $begin_date 开始日期
     * @param string $end_date 结束日期
     * @return array|false
     */
    public function getarticletotal($begin_date, $end_date)
    {
        return $this->action('getarticletotal', $begin_date, $end_date);
    }

    /**
     * 获取图文统计数据
     * @param string $begin_date 开始日期
     * @param string $end_date 结束日期
     * @return array|false
     */
    public function getuserread($begin_date, $end_date)
    {
        return $this->action('getuserread', $begin_date, $end_date);
    }

    /**
     * 获取图文统计分时数据
     * @param string $begin_date 开始日期
     * @param string $end_date 结束日期
     * @return array|false
     */
    public function getuserreadhour($begin_date, $end_date)
    {
        return $this->action('getuserreadhour', $begin_date, $end_date);
    }

    /**
     * 获取图文分享转发数据
     * @param string $begin_date 开始日期
     * @param string $end_date 结束日期
     * @return array|false
     */
    public function getusershare($begin_date, $end_date)
    {
        return $this->action('getusershare', $begin_date, $end_date);
    }

    /**
     * 获取图文分享转发分时数据
     * @param string $begin_date 开始日期
     * @param string $end_date 结束日期
     * @return array|false
     */
    public function getusersharehour($begin_date, $end_date)
    {
        return $this->action('getusersharehour', $begin_date, $end_date);
    }

    /**
     * 获取消息发送概况数据
     * @param string $begin_date 开始日期
     * @param string $end_date 结束日期
     * @return array|false
     */
    public function getupstreammsg($begin_date, $end_date)
    {
        return $this->action('getupstreammsg', $begin_date, $end_date);
    }

    /**
     * 获取消息分送分时数据
     * @param string $begin_date 开始日期
     * @param string $end_date 结束日期
     * @return array|false
     */
    public function getupstreammsghour($begin_date, $end_date)
    {
        return $this->action('getupstreammsghour', $begin_date, $end_date);
    }

    /**
     * 获取消息发送周数据
     * @param string $begin_date 开始日期
     * @param string $end_date 结束日期
     * @return array|false
     */
    public function getupstreammsgweek($begin_date, $end_date)
    {
        return $this->action('getupstreammsgweek', $begin_date, $end_date);
    }

    /**
     * 获取消息发送月数据
     * @param string $begin_date 开始日期
     * @param string $end_date 结束日期
     * @return array|false
     */
    public function getupstreammsgmonth($begin_date, $end_date)
    {
        return $this->action('getupstreammsgmonth', $begin_date, $end_date);
    }

    /**
     * 获取消息发送分布数据
     * @param string $begin_date 开始日期
     * @param string $end_date 结束日期
     * @return array|false
     */
    public function getupstreammsgdist($begin_date, $end_date)
    {
        return $this->action('getupstreammsgdist', $begin_date, $end_date);
    }

    /**
     * 获取消息发送分布周数据
     * @param string $begin_date 开始日期
     * @param string $end_date 结束日期
     * @return array|false
     */
    public function getupstreammsgdistweek($begin_date, $end_date)
    {
        return $this->action('getupstreammsgdistweek', $begin_date, $end_date);
    }

    /**
     * 获取消息发送分布月数据
     * @param string $begin_date 开始日期
     * @param string $end_date 结束日期
     * @return array|false
     */
    public function getupstreammsgdistmonth($begin_date, $end_date)
    {
        return $this->action('getupstreammsgdistmonth', $begin_date, $end_date);
    }

    /**
     * 获取接口分析数据
     * @param string $begin_date 开始日期
     * @param string $end_date 结束日期
     * @return array|false
     */
    public function getinterfacesummary($begin_date, $end_date)
    {
        return $this->action('getinterfacesummary', $begin_date, $end_date);
    }

    /**
     * 获取接口分析分时数据
     * @param string $begin_date 开始日期
     * @param string $end_date 结束日期
     * @return array|false
     */
    public function getinterfacesummaryhour($begin_date, $end_date)
    {
        return $this->action('getinterfacesummaryhour', $begin_date, $end_date);
    }

    /**
     * 数据统计底层方法
     * @param string $action 动作
     * @param string $begin_date 开始日期
     * @param string $end_date 结束日期
     * @return array|false
     */
    private function action($action, $begin_date, $end_date)
    {
        $params = [
            'begin_date' => $begin_date,
            'end_date' => $end_date
        ];
        $json = $this->httpPost("/datacube/{$action}?access_token={$this->accessToken}", $params);
        if (!$json) {
            return false;
        }
        return $json['list'];
    }
}
