<?php


namespace fize\third\wechat\api\shakearound;

use fize\third\wechat\Api;

/**
 * 设备管理
 */
class Device extends Api
{

    /**
     * 申请设备ID
     * @param int $quantity 申请的设备ID的数量
     * @param string $apply_reason 申请理由
     * @param string $comment 备注
     * @param string $poi_id 设备关联的门店ID
     * @return array
     */
    public function applyid($quantity, $apply_reason, $comment = null, $poi_id = null)
    {
        $params = [
            'quantity' => $quantity,
            'apply_reason' => $apply_reason
        ];
        if (!is_null($comment)) {
            $params['comment'] = $comment;
        }
        if (!is_null($poi_id)) {
            $params['poi_id'] = $poi_id;
        }
        return $this->httpPost("/shakearound/device/applyid?access_token={$this->accessToken}", $params);
    }

    /**
     * 查询设备ID申请审核状态
     * @param string $apply_id 批次ID
     * @return array
     */
    public function applystatus($apply_id)
    {
        $params = [
            'apply_id' => $apply_id
        ];
        return $this->httpPost("/shakearound/device/applystatus?access_token={$this->accessToken}", $params);
    }

    /**
     * 编辑设备信息
     * @param array $device_identifier 设备ID
     * @return array
     */
    public function update(array $device_identifier)
    {
        $params = [
            'device_identifier' => $device_identifier
        ];
        return $this->httpPost("/shakearound/device/update?access_token={$this->accessToken}", $params);
    }

    /**
     * 配置设备与门店的关联关系
     * @param array $device_identifier 指定的设备ID
     * @param string $poi_id 设备关联的门店ID
     * @param int $type 门店类型
     * @param string $poi_appid 门店归属的公众账号的APPID
     * @return array
     */
    public function bindlocation(array $device_identifier, $poi_id, $type = null, $poi_appid = null)
    {
        $params = [
            'device_identifier' => $device_identifier,
            'poi_id' => $poi_id
        ];
        if (!is_null($type)) {
            $params['type'] = $type;
        }
        if (!is_null($poi_appid)) {
            $params['poi_appid'] = $poi_appid;
        }
        return $this->httpPost("/shakearound/device/bindlocation?access_token={$this->accessToken}", $params);
    }

    /**
     * 查询设备列表
     * @param array $params 参数
     * @return array
     */
    public function search(array $params)
    {
        return $this->httpPost("/shakearound/device/search?access_token={$this->accessToken}", $params);
    }

    /**
     * 配置设备和页面的关联关系
     * @param array $device_identifier 设备ID
     * @param array $page_ids 待关联的页面列表
     * @return array
     */
    public function bindpage(array $device_identifier, array $page_ids)
    {
        $params = [
            'device_identifier' => $device_identifier,
            'page_ids' => $page_ids
        ];
        return $this->httpPost("/shakearound/device/bindpage?access_token={$this->accessToken}", $params);
    }
}
