<?php


namespace fize\third\wechat\offiaccount\card\giftcard;

use fize\third\wechat\Offiaccount;

/**
 * 礼品卡货架
 */
class Page extends Offiaccount
{
    /**
     * 创建-礼品卡货架
     * @param array $page 货架信息结构体
     * @return string|false 返回货架的ID，失败返回false
     */
    public function add($page)
    {
        $params = [
            'page' => $page,
        ];
        $json = $this->httpPost("/card/giftcard/page/add?access_token={$this->accessToken}", $params);
        if (!$json) {
            return false;
        }
        return $json['page_id'];
    }

    /**
     * 查询-礼品卡货架信息
     * @param string $page_id 货架id
     * @return array|false
     */
    public function get($page_id)
    {
        $params = [
            'page_id' => $page_id,
        ];
        $json = $this->httpPost("/card/giftcard/page/get?access_token={$this->accessToken}", $params);
        if (!$json) {
            return false;
        }
        return $json['page'];
    }

    /**
     * 修改-礼品卡货架信息
     * @param array $page 货架信息结构体
     * @return bool
     */
    public function update($page)
    {
        $params = [
            'page' => $page,
        ];
        $result = $this->httpPost("/card/giftcard/page/update?access_token={$this->accessToken}", $params);
        return $result ? true : false;
    }

    /**
     * 查询-礼品卡货架列表
     * @return array|false
     */
    public function batchget()
    {
        $json = $this->httpPost("/card/giftcard/page/batchget?access_token={$this->accessToken}", '{}', false);
        if (!$json) {
            return false;
        }
        return $json['page_id_list'];
    }
}
