<?php


namespace Fize\Third\Wechat\Api\Card;

use Fize\Third\Wechat\Api;

/**
 * 支付后投放卡券
 */
class Paygiftcard extends Api
{
    /**
     * 设置支付后投放卡券
     * @param string $type 营销规则类型
     * @param array $base_info 营销规则
     * @param array|null $member_rule 支付即会员
     * @return array
     */
    public function add($type, array $base_info, array $member_rule = null)
    {
        $rule_info = [
            'type'      => $type,
            'base_info' => $base_info,
        ];
        if (!is_null($member_rule)) {
            $rule_info['member_rule'] = $member_rule;
        }
        $params = [
            'rule_info' => $rule_info
        ];
        return $this->httpPost("/card/paygiftcard/add?access_token={$this->accessToken}", $params);
    }

    /**
     * 删除支付后投放卡券规则
     * @param string $rule_id 支付即会员的规则名称
     */
    public function delete($rule_id)
    {
        $params = [
            'rule_id' => $rule_id
        ];
        $this->httpPost("/card/paygiftcard/delete?access_token={$this->accessToken}", $params);
    }

    /**
     * 查询支付后投放卡券规则详情
     * @param string $rule_id 支付即会员的规则名称
     * @return array
     */
    public function getbyid($rule_id)
    {
        $params = [
            'rule_id' => $rule_id
        ];
        return $this->httpPost("/card/paygiftcard/getbyid?access_token={$this->accessToken}", $params);
    }

    /**
     * 批量查询支付后投放卡券规则
     * @param string $type 类型
     * @param bool $effective 是否仅查询生效的规则
     * @param int $offset 起始偏移量
     * @param int $count 查询的数量
     * @return array
     */
    public function batchget($type, $effective, $offset, $count)
    {
        $params = [
            'type'      => $type,
            'effective' => $effective,
            'offset'    => $offset,
            'count'     => $count
        ];
        return $this->httpPost("/card/paygiftcard/batchget?access_token={$this->accessToken}", $params);
    }
}
