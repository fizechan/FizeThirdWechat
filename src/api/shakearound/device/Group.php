<?php


namespace fize\third\wechat\api\shakearound\device;

use fize\third\wechat\Api;

/**
 * 设备分组
 */
class Group extends Api
{

    /**
     * 新增分组
     * @param string $group_name 分组名称
     * @return array
     */
    public function add($group_name)
    {
        $params = [
            'group_name' => $group_name
        ];
        return $this->httpPost("/shakearound/device/group/add?access_token={$this->accessToken}", $params);
    }

    /**
     * 编辑分组
     * @param string $group_id 分组ID
     * @param string $group_name 分组名称
     * @return array
     */
    public function update($group_id, $group_name)
    {
        $params = [
            'group_id' => $group_id,
            'group_name' => $group_name
        ];
        return $this->httpPost("/shakearound/device/group/update?access_token={$this->accessToken}", $params);
    }

    /**
     * 删除分组
     * @param string $group_id 分组ID
     * @return array
     */
    public function delete($group_id)
    {
        $params = [
            'group_id' => $group_id
        ];
        return $this->httpPost("/shakearound/device/group/delete?access_token={$this->accessToken}", $params);
    }

    /**
     * 查询分组列表
     * @param int $begin 起始索引值
     * @param int $count 待查询的分组数量
     * @return array
     */
    public function getlist($begin, $count)
    {
        $params = [
            'begin' => $begin,
            'count' => $count
        ];
        return $this->httpPost("/shakearound/device/group/getlist?access_token={$this->accessToken}", $params);
    }

    /**
     * 查询分组详情
     * @param string $group_id 分组唯一标识
     * @param int $begin 起始索引值
     * @param int $count 待查询的分组数量
     * @return array|string
     */
    public function getdetail($group_id, $begin, $count)
    {
        $params = [
            'group_id' => $group_id,
            'begin' => $begin,
            'count' => $count
        ];
        return $this->httpPost("/shakearound/device/group/getdetail?access_token={$this->accessToken}", $params);
    }

    /**
     * 添加设备到分组
     * @param string $group_id 分组唯一标识
     * @param array $device_identifiers 设备id列表
     * @return array
     */
    public function adddevice($group_id, array $device_identifiers)
    {
        $params = [
            'group_id' => $group_id,
            'device_identifiers' => $device_identifiers
        ];
        return $this->httpPost("/shakearound/device/group/adddevice?access_token={$this->accessToken}", $params);
    }

    /**
     * 从分组中移除设备
     * @param string $group_id 分组唯一标识
     * @param array $device_identifiers 设备id列表
     * @return array
     */
    public function deletedevice($group_id, array $device_identifiers)
    {
        $params = [
            'group_id' => $group_id,
            'device_identifiers' => $device_identifiers
        ];
        return $this->httpPost("/shakearound/device/group/deletedevice?access_token={$this->accessToken}", $params);
    }
}
