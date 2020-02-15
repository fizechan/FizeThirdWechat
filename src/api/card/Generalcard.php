<?php


namespace fize\third\wechat\api\card;

use fize\third\wechat\Api;

/**
 * 常规卡券
 */
class Generalcard extends Api
{

    /**
     * 更新用户礼品卡信息
     * @param string $code 卡券Code码
     * @param string $card_id 卡券ID
     * @param string $background_pic_url 自定义的礼品卡背景
     * @param float $balance 需要设置的余额全量值
     * @param string $record_balance 自定义金额消耗记录
     * @param string $custom_field_value1 创建时字段custom_field1定义类型的最新数值
     * @param string $custom_field_value2 创建时字段custom_field2定义类型的最新数值
     * @param string $custom_field_value3 创建时字段custom_field3定义类型的最新数值
     * @param bool $can_give_friend 控制本次积分变动后转赠入口是否出现
     * @return array
     */
    public function updateuser($code, $card_id, $background_pic_url = null, $balance = null, $record_balance = null, $custom_field_value1 = null, $custom_field_value2 = null, $custom_field_value3 = null, $can_give_friend = null)
    {
        $params = [
            'code'    => $code,
            'card_id' => $card_id
        ];
        if (!is_null($background_pic_url)) {
            $params['background_pic_url'] = $background_pic_url;
        }
        if (!is_null($balance)) {
            $params['balance'] = $balance;
        }
        if (!is_null($record_balance)) {
            $params['record_balance'] = $record_balance;
        }
        if (!is_null($custom_field_value1)) {
            $params['custom_field_value1'] = $custom_field_value1;
        }
        if (!is_null($custom_field_value2)) {
            $params['custom_field_value2'] = $custom_field_value2;
        }
        if (!is_null($custom_field_value3)) {
            $params['custom_field_value3'] = $custom_field_value3;
        }
        if (!is_null($can_give_friend)) {
            $params['can_give_friend'] = $can_give_friend;
        }
        return $this->httpPost("/card/generalcard/updateuser?access_token={$this->accessToken}", $params);
    }
}
