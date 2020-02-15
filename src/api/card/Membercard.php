<?php


namespace fize\third\wechat\api\card;

use fize\third\wechat\Api;

/**
 * 会员卡
 */
class Membercard extends Api
{
    /**
     * 激活用户领取的会员卡
     * @param string $membership_number 会员卡编号
     * @param string $code 领取会员卡用户获得的code
     * @param string $card_id 卡券ID
     * @param string $background_pic_url 自定义会员卡背景图
     * @param int $activate_begin_time 激活后的有效起始时间戳
     * @param int $activate_end_time 激活后的有效截至时间戳
     * @param int $init_bonus 初始积分
     * @param int $init_balance 初始余额
     * @param string $init_custom_field_value1 创建时字段custom_field1定义类型的初始值
     * @param string $init_custom_field_value2 创建时字段custom_field2定义类型的初始值
     * @param string $init_custom_field_value3 创建时字段custom_field3定义类型的初始值
     */
    public function activate($membership_number, $code, $card_id = null, $background_pic_url = null, $activate_begin_time = null, $activate_end_time = null, $init_bonus = null, $init_balance = null, $init_custom_field_value1 = null, $init_custom_field_value2 = null, $init_custom_field_value3 = null)
    {
        $params = [
            'membership_number' => $membership_number,
            'code'              => $code,
        ];
        if (!is_null($card_id)) {
            $params['card_id'] = $card_id;
        }
        if (!is_null($background_pic_url)) {
            $params['background_pic_url'] = $background_pic_url;
        }
        if (!is_null($activate_begin_time)) {
            $params['activate_begin_time'] = $activate_begin_time;
        }
        if (!is_null($activate_end_time)) {
            $params['activate_end_time'] = $activate_end_time;
        }
        if (!is_null($init_bonus)) {
            $params['init_bonus'] = $init_bonus;
        }
        if (!is_null($init_balance)) {
            $params['init_balance'] = $init_balance;
        }
        if (!is_null($init_custom_field_value1)) {
            $params['init_custom_field_value1'] = $init_custom_field_value1;
        }
        if (!is_null($init_custom_field_value2)) {
            $params['init_custom_field_value2'] = $init_custom_field_value2;
        }
        if (!is_null($init_custom_field_value3)) {
            $params['init_custom_field_value3'] = $init_custom_field_value3;
        }
        $this->httpPost("/card/membercard/activate?access_token={$this->accessToken}", $params);
    }

    /**
     * 更新会员信息
     * @param string $code Code码
     * @param string $card_id 卡券ID
     * @param array $extend 其他字段
     * @return array
     */
    public function updateuser($code, $card_id, array $extend = [])
    {
        $params = [
            'code'    => $code,
            'card_id' => $card_id
        ];
        $params = array_merge($params, $extend);
        return $this->httpPost("/card/membercard/updateuser?access_token={$this->accessToken}", $params);
    }
}
