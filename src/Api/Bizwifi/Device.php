<?php


namespace Fize\Third\Wechat\Api\Bizwifi;

use Fize\Third\Wechat\Api;

/**
 * 设备管理
 */
class Device extends Api
{

    /**
     * 添加密码型设备
     * @param string $shop_id 门店ID
     * @param string $ssid 无线SSID
     * @param string $password 密码
     * @return array
     */
    public function add($shop_id, $ssid, $password)
    {
        $params = [
            'shop_id' => $shop_id,
            'ssid' => $ssid,
            'password' => $password
        ];
        return $this->httpPost("/bizwifi/device/add?access_token={$this->accessToken}", $params);
    }

    /**
     * 查询设备
     * @param int $pageindex 分页下标
     * @param int $pagesize 每页的个数
     * @param string $shop_id 门店ID
     * @return array
     */
    public function list($pageindex = null, $pagesize = null, $shop_id = null)
    {
        $params = [];
        if (!is_null($pageindex)) {
            $params['pageindex'] = $pageindex;
        }
        if (!is_null($pagesize)) {
            $params['pagesize'] = $pagesize;
        }
        if (!is_null($shop_id)) {
            $params['shop_id'] = $shop_id;
        }
        return $this->httpPost("/bizwifi/device/list?access_token={$this->accessToken}", $params);
    }

    /**
     * 删除设备
     * @param string $bssid 设备无线mac地址
     * @return array
     */
    public function delete($bssid)
    {
        $params = [
            'bssid' => $bssid
        ];
        return $this->httpPost("/bizwifi/device/delete?access_token={$this->accessToken}", $params);
    }
}
