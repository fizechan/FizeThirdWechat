<?php


namespace fize\third\wechat\api;

use fize\third\wechat\ApiAbstract;

/**
 * 微信门店小程序
 */
class Wxa extends ApiAbstract
{

    /**
     * 拉取门店小程序类目
     * @return array
     */
    public function getMerchantCategory()
    {
        return $this->httpGet("/wxa/get_merchant_category?access_token={$this->accessToken}");
    }

    /**
     * 创建门店小程序
     * @param int          $first_catid        一级类目ID
     * @param int          $second_catid       二级类目ID
     * @param string       $headimg_mediaid    头像临时素材ID
     * @param string       $nickname           昵称
     * @param string       $intro              介绍
     * @param string|array $qualification_list 类目相关证件临时素材ID
     * @param string       $org_code           营业执照或组织代码证
     * @param string|array $other_files        补充材料临时素材ID
     * @return bool
     */
    public function applyMerchant($first_catid, $second_catid, $headimg_mediaid, $nickname, $intro, $qualification_list = null, $org_code = null, $other_files = null)
    {
        $params = [
            'first_catid'     => $first_catid,
            'second_catid'    => $second_catid,
            'headimg_mediaid' => $headimg_mediaid,
            'nickname'        => $nickname,
            'intro'           => $intro
        ];
        if (!is_null($qualification_list)) {
            $params['qualification_list'] = $qualification_list;
        }
        if (!is_null($org_code)) {
            $params['org_code'] = $org_code;
        }
        if (!is_null($other_files)) {
            $params['other_files'] = $other_files;
        }

        $result = $this->httpPost("/wxa/apply_merchant?access_token={$this->accessToken}", $params);
        return $result ? true : false;
    }

    /**
     * 查询门店小程序审核结果
     * @return array
     */
    public function getMerchantAuditInfo()
    {
        return $this->httpGet("/wxa/get_merchant_audit_info?access_token={$this->accessToken}");
    }

    /**
     * 修改门店小程序信息
     * @param string $headimg_mediaid 头像临时素材ID
     * @param string $intro           介绍
     * @return bool
     */
    public function modifyMerchant($headimg_mediaid, $intro)
    {
        $params = [
            'headimg_mediaid' => $headimg_mediaid,
            'intro'           => $intro
        ];
        $result = $this->httpPost("/wxa/modify_merchant?access_token={$this->accessToken}", $params);
        return $result ? true : false;
    }

    /**
     * 从腾讯地图拉取省市区信息
     * @return array
     */
    public function getDistrict()
    {
        return $this->httpGet("/wxa/get_district?access_token={$this->accessToken}");
    }

    /**
     * 在腾讯地图中搜索门店
     * @param int    $districtid 对应拉取省市区信息接口中的id字段
     * @param string $keyword    搜索的关键词
     * @return array
     */
    public function searchMapPoi($districtid, $keyword)
    {
        $params = [
            'districtid' => $districtid,
            'keyword'    => $keyword
        ];
        return $this->httpPost("/wxa/search_map_poi?access_token={$this->accessToken}", $params);
    }

    /**
     * 在腾讯地图中创建门店
     * @param array $params 参数
     * @return array
     */
    public function createMapPoi(array $params)
    {
        return $this->httpPost("/wxa/create_map_poi?access_token={$this->accessToken}", $params);
    }

    /**
     * 添加门店
     * @param array $params 参数
     * @return array
     */
    public function addStore(array $params)
    {
        return $this->httpPost("/wxa/add_store?access_token={$this->accessToken}", $params);
    }

    /**
     * 更新门店信息
     * @param array $params 参数
     * @return array
     */
    public function updateStore(array $params)
    {
        return $this->httpPost("/wxa/update_store?access_token={$this->accessToken}", $params);
    }

    /**
     * 获取单个门店信息
     * @param $poi_id
     * @return array
     */
    public function getStoreInfo($poi_id)
    {
        $params = [
            'poi_id' => $poi_id
        ];
        return $this->httpPost("/wxa/get_store_info?access_token={$this->accessToken}", $params);
    }

    /**
     * 获取门店信息列表
     * @param $offset
     * @param $limit
     * @return array
     */
    public function getStoreList($offset, $limit)
    {
        $params = [
            'offset' => $offset,
            'limit'  => $limit
        ];
        return $this->httpPost("/wxa/get_store_list?access_token={$this->accessToken}", $params);
    }

    /**
     * 删除门店
     * @param $poi_id
     * @return array
     */
    public function delStore($poi_id)
    {
        $params = [
            'poi_id' => $poi_id
        ];
        return $this->httpPost("/wxa/del_store?access_token={$this->accessToken}", $params);
    }
}
