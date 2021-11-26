<?php


namespace Fize\Third\Wechat\Api\Shakearound;

use Fize\Third\Wechat\Api;

/**
 * 摇一摇红包
 */
class Lottery extends Api
{

    /**
     * 创建红包活动
     * @param int $use_template 是否使用模板
     * @param string $logo_url 使用模板页面的logo_url
     * @param array $params 参数
     * @return array
     */
    public function addlotteryinfo($use_template, $logo_url, array $params)
    {
        $logo_url = urlencode($logo_url);
        return $this->httpPost("/shakearound/lottery/addlotteryinfo?access_token={$this->accessToken}&use_template={$use_template}&logo_url={$logo_url}", $params);
    }

    /**
     * 录入红包信息
     * @param string $lottery_id 红包抽奖id
     * @param string $mchid 红包提供者的商户号
     * @param string $sponsor_appid 红包提供商户公众号的appid
     * @param array $prize_info_list 红包ticket列表
     * @return array
     */
    public function setprizebucket($lottery_id, $mchid, $sponsor_appid, array $prize_info_list)
    {
        $params = [
            'lottery_id' => $lottery_id,
            'mchid' => $mchid,
            'sponsor_appid' => $sponsor_appid,
            'prize_info_list' => $prize_info_list
        ];
        return $this->httpPost("/shakearound/lottery/setprizebucket?access_token={$this->accessToken}", $params);
    }

    /**
     * 设置红包活动抽奖开关
     * @param string $lottery_id 红包抽奖id
     * @param int $onoff 活动抽奖开关
     * @return array
     */
    public function setlotteryswitch($lottery_id, $onoff)
    {
        $params = [
            'lottery_id' => $lottery_id,
            'onoff' => $onoff
        ];
        return $this->httpPost("/shakearound/lottery/setlotteryswitch?access_token={$this->accessToken}", $params);
    }

    /**
     * 查询红包活动信息
     * @param string $lottery_id 红包抽奖id
     * @return array
     */
    public function querylottery($lottery_id)
    {
        $params = [
            'lottery_id' => $lottery_id
        ];
        return $this->httpPost("/shakearound/lottery/querylottery?access_token={$this->accessToken}", $params);
    }
}
