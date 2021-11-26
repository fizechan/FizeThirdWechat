<?php


namespace Fize\Third\Wechat\Api\Bizwifi;

use Fize\Third\Wechat\Api;

/**
 * 门店管理
 */
class Shop extends Api
{

    /**
     * 获取WI-FI门店列表
     * @param int $pageindex 分页下标
     * @param int $pagesize 每页的个数
     * @return array
     */
    public function list($pageindex = null, $pagesize = null)
    {
        $params = [];
        if (!is_null($pageindex)) {
            $params['pageindex'] = $pageindex;
        }
        if (!is_null($pagesize)) {
            $params['pagesize'] = $pagesize;
        }
        return $this->httpPost("/bizwifi/shop/list?access_token={$this->accessToken}", $params);
    }

    /**
     * 查询门店WiFi信息
     * @param int $shop_id 门店ID
     * @return array
     */
    public function get($shop_id)
    {
        $params = [
            'shop_id' => $shop_id
        ];
        return $this->httpPost("/bizwifi/shop/get?access_token={$this->accessToken}", $params);
    }

    /**
     * 修改门店网路信息
     * @param string $shop_id 门店ID
     * @param string $old_ssid 原SSID
     * @param string $ssid 新SSID
     * @param string $password 无线网络设备的密码
     * @return array
     */
    public function update($shop_id, $old_ssid, $ssid, $password = null)
    {
        $params = [
            'shop_id'  => $shop_id,
            'old_ssid' => $old_ssid,
            'ssid'     => $ssid
        ];
        if (!is_null($password)) {
            $params['password'] = $password;
        }
        return $this->httpPost("/bizwifi/shop/update?access_token={$this->accessToken}", $params);
    }

    /**
     * 清空门店网络及设置
     * @param string $shop_id 门店ID
     * @return array
     */
    public function clean($shop_id)
    {
        $params = [
            'shop_id' => $shop_id
        ];
        return $this->httpPost("/bizwifi/shop/clean?access_token={$this->accessToken}", $params);
    }
}
