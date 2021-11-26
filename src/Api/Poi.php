<?php

namespace Fize\Third\Wechat\Api;

use Fize\Third\Wechat\ApiAbstract;

/**
 * 微信门店
 */
class Poi extends ApiAbstract
{

    /**
     * 创建门店
     * @param array $base_info 门店信息
     * @return string 返回 门店ID
     */
    public function addpoi(array $base_info)
    {
        $params = [
            'business' => [
                'base_info' => $base_info
            ]
        ];
        $result = $this->httpPost("/poi/addpoi?access_token={$this->accessToken}", $params);
        return $result['poi_id'];
    }

    /**
     * 查询门店信息
     * @param string $poi_id 门店ID
     * @return array
     */
    public function getpoi($poi_id)
    {
        $params = [
            'poi_id' => $poi_id
        ];
        $result = $this->httpPost("/poi/getpoi?access_token={$this->accessToken}", $params);
        return $result['business']['base_info'];
    }

    /**
     * 查询门店列表
     * @param int $begin 开始位置
     * @param int $limit 返回数据条数
     * @return mixed
     */
    public function getpoilist($begin, $limit)
    {
        $params = [
            'begin' => $begin,
            'limit' => $limit
        ];
        $result = $this->httpPost("/poi/getpoilist?access_token={$this->accessToken}", $params);
        return $result['business_list'];
    }

    /**
     * 修改门店服务信息
     * @param string $poi_id    门店ID
     * @param array  $base_info 门店信息
     */
    public function updatepoi($poi_id, array $base_info)
    {
        $base_info['poi_id'] = $poi_id;
        $params = [
            'business' => [
                'base_info' => $base_info
            ]
        ];
        $this->httpPost("/poi/updatepoi?access_token={$this->accessToken}", $params);
    }

    /**
     * 删除门店
     * @param string $poi_id 门店ID
     */
    public function delpoi($poi_id)
    {
        $params = [
            'poi_id' => $poi_id
        ];
        $this->httpPost("/poi/delpoi?access_token={$this->accessToken}", $params);
    }

    /**
     * 门店类目表
     * @return array
     */
    public function getwxcategory()
    {
        return $this->httpGet("/poi/getwxcategory?access_token={$this->accessToken}");
    }
}
