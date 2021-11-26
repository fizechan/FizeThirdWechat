<?php


namespace Fize\Third\Wechat\Api\Card\Giftcard;

use Fize\Third\Wechat\Api;

/**
 * 礼品卡货架
 */
class Page extends Api
{
    /**
     * 创建-礼品卡货架
     * @param array $page 货架信息结构体
     * @return string 返回货架的ID
     */
    public function add($page)
    {
        $params = [
            'page' => $page,
        ];
        $result = $this->httpPost("/card/giftcard/page/add?access_token={$this->accessToken}", $params);
        return $result['page_id'];
    }

    /**
     * 查询-礼品卡货架信息
     * @param string $page_id 货架id
     * @return array
     */
    public function get($page_id)
    {
        $params = [
            'page_id' => $page_id,
        ];
        $result = $this->httpPost("/card/giftcard/page/get?access_token={$this->accessToken}", $params);
        return $result['page'];
    }

    /**
     * 修改-礼品卡货架信息
     * @param array $page 货架信息结构体
     */
    public function update($page)
    {
        $params = [
            'page' => $page,
        ];
        $this->httpPost("/card/giftcard/page/update?access_token={$this->accessToken}", $params);
    }

    /**
     * 查询-礼品卡货架列表
     * @return array
     */
    public function batchget()
    {
        $result = $this->httpPost("/card/giftcard/page/batchget?access_token={$this->accessToken}", '{}', false);
        return $result['page_id_list'];
    }
}
