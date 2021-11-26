<?php


namespace Fize\Third\Wechat\Api\Card;

use Fize\Third\Wechat\Api;

/**
 * 子商户
 */
class Submerchant extends Api
{

    /**
     * 创建子商户
     * @param array $info 子商户信息
     * @return array
     */
    public function submit(array $info)
    {
        $params = [
            'info' => $info,
        ];
        return $this->httpPost("/card/submerchant/submit?access_token={$this->accessToken}", $params);
    }

    /**
     * 更新子商户
     * @param array $info 子商户信息
     * @return array
     */
    public function update(array $info)
    {
        $params = [
            'info' => $info,
        ];
        return $this->httpPost("/card/submerchant/update?access_token={$this->accessToken}", $params);
    }

    /**
     * 拉取单个子商户信息
     * @param string $merchant_id 子商户ID
     * @return array
     */
    public function get($merchant_id)
    {
        $params = [
            'merchant_id' => $merchant_id,
        ];
        $result = $this->httpPost("/card/submerchant/get?access_token={$this->accessToken}", $params);
        return $result['info'];
    }

    /**
     * 批量拉取子商户信息
     * @param int $begin_id 起始的子商户ID
     * @param int $limit 拉取的子商户的个数
     * @param string $status 子商户审核状态
     * @return array
     */
    public function batchget($begin_id, $limit, $status = null)
    {
        $params = [
            'begin_id' => $begin_id,
            'limit'    => $limit
        ];
        if (is_null($status)) {
            $params['status'] = $status;
        }
        $result = $this->httpPost("/card/submerchant/batchget?access_token={$this->accessToken}", $params);
        return $result['info_list'];
    }
}
