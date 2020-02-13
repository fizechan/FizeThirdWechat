<?php


namespace fize\third\wechat\api;


use fize\third\wechat\Api;


/**
 * 微信卡券
 */
class Card extends Api
{

    /**
     * 场景值：附近
     */
    const SCENE_NEAR_BY = 'SCENE_NEAR_BY';

    /**
     * 场景值：自定义菜单
     */
    const SCENE_MENU = 'SCENE_MENU';

    /**
     * 场景值：二维码
     */
    const SCENE_QRCODE = 'SCENE_QRCODE';

    /**
     * 场景值：公众号文章
     */
    const SCENE_ARTICLE = 'SCENE_ARTICLE';

    /**
     * 场景值：H5页面
     */
    const SCENE_H5 = 'SCENE_H5';

    /**
     * 场景值：自动回复
     */
    const SCENE_IVR = 'SCENE_IVR';

    /**
     * 场景值：卡券自定义列
     */
    const SCENE_CARD_CUSTOM_CELL = 'SCENE_CARD_CUSTOM_CELL';

    /**
     * 卡券状态：待审核
     */
    const CARD_STATUS_NOT_VERIFY = 'CARD_STATUS_NOT_VERIFY';

    /**
     * 卡券状态：审核失败
     */
    const CARD_STATUS_VERIFY_FAIL = 'CARD_STATUS_VERIFY_FAIL';

    /**
     * 卡券状态：通过审核
     */
    const CARD_STATUS_VERIFY_OK = 'CARD_STATUS_VERIFY_OK';

    /**
     * 卡券状态：卡券被商户删除
     */
    const CARD_STATUS_DELETE = 'CARD_STATUS_DELETE';

    /**
     * 卡券状态：在公众平台投放过的卡券
     */
    const CARD_STATUS_DISPATCH = 'CARD_STATUS_DISPATCH';

    /**
     * 创建卡券
     * @param array $card 卡券数据
     * @return array|false 返回数组中card_id为卡券ID
     * @see https://developers.weixin.qq.com/doc/offiaccount/Cards_and_Offer/Create_a_Coupon_Voucher_or_Card.html
     */
    public function create(array $card)
    {
        $params = [
            'card' => $card
        ];
        return $this->httpPost("/card/create?access_token={$this->accessToken}", $params);
    }

    /**
     * 设置买单
     * @param string $card_id 卡券ID
     * @param bool $is_open 是否开启买单功能
     * @return bool
     */
    public function paycellSet($card_id, $is_open)
    {
        $params = [
            'card_id' => $card_id,
            'is_open' => $is_open
        ];
        $result = $this->httpPost("/card/paycell/set?access_token={$this->accessToken}", $params);
        return $result ? true : false;
    }

    /**
     * 设置自助核销
     * @param string $card_id 卡券ID
     * @param bool $is_open 是否开启自助核销功能
     * @param bool $need_verify_cod 用户核销时是否需要输入验证码
     * @param bool $need_remark_amount 用户核销时是否需要备注核销金额
     * @return bool
     */
    public function selfconsumecellSet($card_id, $is_open, $need_verify_cod = false, $need_remark_amount = false)
    {
        $params = [
            'card_id' => $card_id,
            'is_open' => $is_open,
            'need_verify_cod' => $need_verify_cod,
            'need_remark_amount' => $need_remark_amount
        ];
        $result = $this->httpPost("/card/selfconsumecell/set?access_token={$this->accessToken}", $params);
        return $result ? true : false;
    }

    /**
     * 创建货架
     * @param string $banner 页面的banner图片链接
     * @param string $title 页面的title
     * @param bool $can_share 页面是否可以分享
     * @param string $scene 投放页面的场景值
     * @param array $card_list 卡券列表
     * @return array|false
     * @see https://developers.weixin.qq.com/doc/offiaccount/Cards_and_Offer/Distributing_Coupons_Vouchers_and_Cards.html#3
     */
    public function landingpageCreate($banner, $title, $can_share, $scene, array $card_list)
    {
        $params = [
            'banner' => $banner,
            'title' => $title,
            'can_share' => $can_share,
            'scene' => $scene,
            'card_list' => $card_list
        ];
        return $this->httpPost("/card/landingpage/create?access_token={$this->accessToken}", $params);
    }

    /**
     * 导入code
     * @param string $card_id 需要进行导入code的卡券ID
     * @param array $code 需导入微信卡券后台的自定义code
     * @return bool
     */
    public function codeDeposit($card_id, array $code)
    {
        $params = [
            'card_id' => $card_id,
            'code' => $code
        ];
        $result = $this->httpPost("/card/code/deposit?access_token={$this->accessToken}", $params);
        return $result ? true : false;
    }

    /**
     * 查询导入code数目
     * @param string $card_id 进行导入code的卡券ID
     * @return int|false
     */
    public function codeGetdepositcount($card_id)
    {
        $params = [
            'card_id' => $card_id
        ];
        $json = $this->httpPost("/card/code/getdepositcount?access_token={$this->accessToken}", $params);
        if (!$json) {
            return false;
        }
        return $json['count'];
    }

    /**
     * 核查code
     * @param string $card_id 需要进行导入code的卡券ID
     * @param array $code 需导入微信卡券后台的自定义code
     * @return array|false
     */
    public function codeCheckcode($card_id, array $code)
    {
        $params = [
            'card_id' => $card_id,
            'code' => $code
        ];
        return $this->httpPost("/card/code/checkcode?access_token={$this->accessToken}", $params);
    }

    /**
     * 获取卡券嵌入图文消息的标准格式代码
     * @param string $card_id 卡券ID
     * @return string|false
     */
    public function mpnewsGethtml($card_id)
    {
        $params = [
            'card_id' => $card_id
        ];
        $json = $this->httpPost("/card/mpnews/gethtml?access_token={$this->accessToken}", $params);
        if (!$json) {
            return false;
        }
        return $json['content'];
    }

    /**
     * 设置测试白名单
     * @param string|array $openid 测试的openid
     * @param string|array $username 测试的微信号
     * @return bool
     */
    public function testwhitelistSet($openid = null, $username = null)
    {
        $params = [];
        if(!is_null($openid)) {
            if (is_string($openid)) {
                $openid = [$openid];
            }
            $params['openid'] = $openid;
        }
        if(!is_null($username)) {
            if (is_string($username)) {
                $username = [$username];
            }
            $params['username'] = $username;
        }
        $result = $this->httpPost("/card/testwhitelist/set?access_token={$this->accessToken}", $params);
        return $result ? true : false;
    }

    /**
     * 查询Code
     * @param string $code 单张卡券的唯一标准
     * @param string $card_id 卡券ID代表一类卡券
     * @param bool $check_consume 是否校验code核销状态
     * @return array|false
     */
    public function codeGet($code, $card_id = null, $check_consume = null)
    {
        $params = [
            'code' => $code
        ];
        if (!is_null($card_id)) {
            $params['card_id'] = $card_id;
        }
        if (!is_null($check_consume)) {
            $params['check_consume'] = $check_consume;
        }
        return $this->httpPost("/card/code/get?access_token={$this->accessToken}", $params);
    }

    /**
     * 核销Code
     * @param string $code 单张卡券的唯一标准
     * @param string $card_id 卡券ID代表一类卡券
     * @return array|false
     */
    public function codeConsume($code, $card_id = null)
    {
        $params = [
            'code' => $code
        ];
        if (!is_null($card_id)) {
            $params['card_id'] = $card_id;
        }
        return $this->httpPost("/card/code/consume?access_token={$this->accessToken}", $params);
    }

    /**
     * Code解码
     * @param string $encrypt_code 经过加密的Code码
     * @return string|false
     */
    public function codeDecrypt($encrypt_code)
    {
        $params = [
            'encrypt_code' => $encrypt_code
        ];
        $json = $this->httpPost("/card/code/decrypt?access_token={$this->accessToken}", $params);
        if (!$json) {
            return false;
        }
        return $json['code'];
    }

    /**
     * 获取用户已领取卡券
     * @param string $openid 需要查询的用户openid
     * @param string $card_id 卡券ID。不填写时默认查询当前appid下的卡券
     * @return bool|mixed
     */
    public function userGetcardlist($openid, $card_id = null)
    {
        $params = [
            'openid' => $openid
        ];
        if (!is_null($card_id)) {
            $params['card_id'] = $card_id;
        }
        return $this->httpPost("/card/user/getcardlist?access_token={$this->accessToken}", $params);
    }

    /**
     * 查看卡券详情
     * @param string $card_id 卡券ID
     * @return array|false
     */
    public function get($card_id)
    {
        $params = [
            'card_id' => $card_id
        ];
        $json = $this->httpPost("/card/get?access_token={$this->accessToken}", $params);
        if (!$json) {
            return false;
        }
        return $json['code'];
    }

    /**
     * 批量查询卡券列表
     * @param int $offset 查询卡列表的起始偏移量
     * @param int $count 需要查询的卡片的数量
     * @param array $status_list 拉出指定状态的卡券列表
     * @return array|false
     */
    public function batchget($offset, $count, $status_list = null)
    {
        $params = [
            'offset' => $offset,
            'count' => $count
        ];
        if (!is_null($status_list)) {
            $params['status_list'] = $status_list;
        }
        return $this->httpPost("/card/batchget?access_token={$this->accessToken}", $params);
    }

    /**
     * 更改卡券信息
     * @param string $card_id 卡券ID
     * @param string $card_type 卡券类型
     * @param array $data 卡券信息
     * @return array|false
     */
    public function update($card_id, $card_type, array $data)
    {
        $params = [
            'card_id' => $card_id,
            $card_type => $data
        ];
        return $this->httpPost("/card/update?access_token={$this->accessToken}", $params);
    }

    /**
     * 修改库存
     * @param string $card_id 卡券ID
     * @param int $increase_stock_value 增加多少库存
     * @param int $reduce_stock_value 减少多少库存
     * @return bool
     */
    public function modifystock($card_id, $increase_stock_value = null, $reduce_stock_value = null)
    {
        $params = [
            'card_id' => $card_id
        ];
        if(!is_null($increase_stock_value)) {
            $params['increase_stock_value'] = $increase_stock_value;
        }
        if(!is_null($reduce_stock_value)) {
            $params['reduce_stock_value'] = $reduce_stock_value;
        }
        $result = $this->httpPost("/card/modifystock?access_token={$this->accessToken}", $params);
        return $result ? true : false;
    }

    /**
     * 更改Code
     * @param string $code 需变更的Code码
     * @param string $new_code 变更后的有效Code码
     * @param string $card_id 卡券ID
     * @return bool
     */
    public function codeUpdate($code, $new_code, $card_id = null)
    {
        $params = [
            'code' => $code,
            'new_code' => $new_code
        ];
        if(!is_null($card_id)) {
            $params['card_id'] = $card_id;
        }
        $result = $this->httpPost("/card/code/update?access_token={$this->accessToken}", $params);
        return $result ? true : false;
    }

    /**
     * 删除卡券
     * @param string $card_id 卡券ID
     * @return bool
     */
    public function delete($card_id)
    {
        $params = [
            'card_id' => $card_id
        ];
        $result = $this->httpPost("/card/delete?access_token={$this->accessToken}", $params);
        return $result ? true : false;
    }

    /**
     * 设置卡券失效
     * @param string $card_id 卡券ID
     * @param string $code 设置失效的Code码
     * @param string $reason 失效理由
     * @return bool
     */
    public function codeUnavailable($card_id, $code, $reason = null)
    {
        $params = [
            'card_id' => $card_id,
            'code' => $code,
        ];
        if(!is_null($reason)) {
            $params['reason'] = $reason;
        }
        $result = $this->httpPost("/card/code/unavailable?access_token={$this->accessToken}", $params);
        return $result ? true : false;
    }

    /**
     * 获取开卡插件参数
     * @param string $card_id 卡券ID
     * @param string $outer_str 渠道值
     * @return string|false 返回的url，内含调用开卡插件所需的参数
     */
    public function membercardActivateGeturl($card_id, $outer_str = null)
    {
        $params = [
            'card_id' => $card_id,
            'outer_str' => $outer_str
        ];
        $json = $this->httpPost("/card/membercard/activate/geturl?access_token={$this->accessToken}", $params);
        if (!$json) {
            return false;
        }
        return $json['url'];
    }

    /**
     * 获取用户开卡时提交的信息
     * @param string $activate_ticket 跳转型开卡组件开卡后回调中的激活票据，可以用来获取用户开卡资料
     * @return array|false
     */
    public function membercardActivatetempinfoGet($activate_ticket)
    {
        $params = [
            'activate_ticket' => $activate_ticket,
        ];
        $json = $this->httpPost("/card/membercard/activatetempinfo/get?access_token={$this->accessToken}", $params);
        if (!$json) {
            return false;
        }
        return $json['info'];
    }

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
     * @return bool
     */
    public function membercardActivate($membership_number, $code, $card_id = null, $background_pic_url = null, $activate_begin_time = null, $activate_end_time = null, $init_bonus = null, $init_balance = null, $init_custom_field_value1 = null, $init_custom_field_value2 = null, $init_custom_field_value3 = null)
    {
        $params = [
            'membership_number' => $membership_number,
            'code' => $code,
        ];
        if(!is_null($card_id)) {
            $params['card_id'] = $card_id;
        }
        if(!is_null($background_pic_url)) {
            $params['background_pic_url'] = $background_pic_url;
        }
        if(!is_null($activate_begin_time)) {
            $params['activate_begin_time'] = $activate_begin_time;
        }
        if(!is_null($activate_end_time)) {
            $params['activate_end_time'] = $activate_end_time;
        }
        if(!is_null($init_bonus)) {
            $params['init_bonus'] = $init_bonus;
        }
        if(!is_null($init_balance)) {
            $params['init_balance'] = $init_balance;
        }
        if(!is_null($init_custom_field_value1)) {
            $params['init_custom_field_value1'] = $init_custom_field_value1;
        }
        if(!is_null($init_custom_field_value2)) {
            $params['init_custom_field_value2'] = $init_custom_field_value2;
        }
        if(!is_null($init_custom_field_value3)) {
            $params['init_custom_field_value3'] = $init_custom_field_value3;
        }
        $result = $this->httpPost("/card/membercard/activate?access_token={$this->accessToken}", $params);
        return $result ? true : false;
    }

    /**
     * 创建-礼品卡货架
     * @param array $page 货架信息结构体
     * @return string|false 返回货架的ID，失败返回false
     */
    public function giftcardPageAdd($page)
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
    public function giftcardPageGet($page_id)
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
    public function giftcardPageUpdate($page)
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
    public function giftcardPageBatchget()
    {
        $json = $this->httpPost("/card/giftcard/page/batchget?access_token={$this->accessToken}", '{}', false);
        if (!$json) {
            return false;
        }
        return $json['page_id_list'];
    }

    /**
     * 下架-礼品卡货架
     * @param string $page_id 需要下架的page_id
     * @param bool $all 是否将该商户下所有的货架设置为下架
     * @param bool $maintain 为true表示下架
     * @return bool
     */
    public function giftcardMaintainSet($page_id = null, $all = null, $maintain = true)
    {
        $params = [
            'maintain' => $maintain
        ];
        if(!is_null($page_id)) {
            $params['page_id'] = $page_id;
        }
        if(!is_null($all)) {
            $params['all'] = $all;
        }
        $result = $this->httpPost("/card/giftcard/maintain/set?access_token={$this->accessToken}", $params);
        return $result ? true : false;
    }

    /**
     * 申请微信支付礼品卡权限
     * @param string $sub_mch_id 微信支付子商户号
     * @return array|false
     */
    public function giftcardPayWhitelistAdd($sub_mch_id)
    {
        $params = [
            'sub_mch_id' => $sub_mch_id
        ];
        return $this->httpPost("/card/giftcard/pay/whitelist/add?access_token={$this->accessToken}", $params);
    }

    /**
     * 绑定商户号到礼品卡小程序
     * @param string $sub_mch_id 商户号
     * @param string $wxa_appid 小程序APPID
     * @return bool
     */
    public function giftcardPaySubmchBind($sub_mch_id, $wxa_appid)
    {
        $params = [
            'sub_mch_id' => $sub_mch_id,
            'wxa_appid' => $wxa_appid
        ];
        $result = $this->httpPost("/card/giftcard/pay/submch/bind?access_token={$this->accessToken}", $params);
        return $result ? true : false;
    }

    /**
     * 上传小程序代码
     * @param string $wxa_appid 小程序APPID
     * @param string $page_id 页面ID
     * @return bool
     */
    public function giftcardWxaSet($wxa_appid, $page_id)
    {
        $params = [
            'wxa_appid' => $wxa_appid,
            'page_id' => $page_id
        ];
        $result = $this->httpPost("/card/giftcard/wxa/set?access_token={$this->accessToken}", $params);
        return $result ? true : false;
    }

    /**
     * 查询-单个礼品卡订单信息
     * @param string $order_id 礼品卡订单号
     * @return array|false 返回订单结构体，失败时返回false
     */
    public function giftcardOrderGet($order_id)
    {
        $params = [
            'order_id' => $order_id,
        ];
        $json = $this->httpPost("/card/giftcard/order/get?access_token={$this->accessToken}", $params);
        if (!$json) {
            return false;
        }
        return $json['order'];
    }

    /**
     * 查询-批量查询礼品卡订单信息
     * @param int $begin_time 查询的时间起点，十位时间戳
     * @param int $end_time 查询的时间终点，十位时间戳
     * @param int $count 查询订单的数量
     * @param int $offset 查询的订单偏移量
     * @param string $sort_type 填"ASC" / "DESC"，表示对订单创建时间进行“升 / 降”排序
     * @return array|false
     */
    public function giftcardOrderBatchget($begin_time, $end_time, $count, $offset = 0, $sort_type = 'ASC')
    {
        $params = [
            'begin_time' => $begin_time,
            'end_time' => $end_time,
            'count' => $count,
            'offset' => $offset,
            'sort_type' => $sort_type
        ];
        return $this->httpPost("/card/giftcard/order/batchget?access_token={$this->accessToken}", $params);
    }

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
     * @return array|false
     */
    public function generalcardUpdateuser($code, $card_id, $background_pic_url = null, $balance = null, $record_balance = null, $custom_field_value1 = null, $custom_field_value2 = null, $custom_field_value3 = null, $can_give_friend = null)
    {
        $params = [
            'code' => $code,
            'card_id' => $card_id
        ];
        if(!is_null($background_pic_url)) {
            $params['background_pic_url'] = $background_pic_url;
        }
        if(!is_null($balance)) {
            $params['balance'] = $balance;
        }
        if(!is_null($record_balance)) {
            $params['record_balance'] = $record_balance;
        }
        if(!is_null($custom_field_value1)) {
            $params['custom_field_value1'] = $custom_field_value1;
        }
        if(!is_null($custom_field_value2)) {
            $params['custom_field_value2'] = $custom_field_value2;
        }
        if(!is_null($custom_field_value3)) {
            $params['custom_field_value3'] = $custom_field_value3;
        }
        if(!is_null($can_give_friend)) {
            $params['can_give_friend'] = $can_give_friend;
        }
        return $this->httpPost("/card/generalcard/updateuser?access_token={$this->accessToken}", $params);
    }

    /**
     * 退款
     * @param string $order_id 订单id
     * @return bool
     */
    public function giftcardOrderRefund($order_id)
    {
        $params = [
            'order_id' => $order_id
        ];
        $result = $this->httpPost("/card/giftcard/order/refund?access_token={$this->accessToken}", $params);
        return $result ? true : false;
    }

    /**
     * 设置支付后开票信息
     * @param string $mchid 微信支付商户号
     * @param string $s_pappid 开票平台ID
     * @return bool
     */
    public function invoiceSetbizattrSetPayMch($mchid, $s_pappid)
    {
        $params = [
            'paymch_info' => [
                'mchid' => $mchid,
                's_pappid' => $s_pappid
            ]
        ];
        $result = $this->httpPost("/card/invoice/setbizattr?action=set_pay_mch&access_token={$this->accessToken}", $params);
        return $result ? true : false;
    }

    /**
     * 查询支付后开票信息
     * @return array|false
     */
    public function invoiceSetbizattrGetPayMch()
    {
        $result = $this->httpPost("/card/invoice/setbizattr?action=get_pay_mch&access_token={$this->accessToken}", '{}', false);
        if (!$result) {
            return false;
        }
        return $result['paymch_info'];
    }

    /**
     * 设置授权页字段信息
     * @param array $user_field 授权页个人发票字段
     * @param array $biz_field 授权页单位发票字段
     * @return bool
     */
    public function invoiceSetbizattrSetAuthField(array $user_field, array $biz_field)
    {
        $params = [
            'auth_field' => [
                'user_field' => $user_field,
                'biz_field' => $biz_field
            ]
        ];
        $result = $this->httpPost("/card/invoice/setbizattr?action=set_auth_field&access_token={$this->accessToken}", $params);
        return $result ? true : false;
    }

    /**
     * 查询授权页字段信息
     * @return array|false
     */
    public function invoiceSetbizattrGetAuthField()
    {
        $result = $this->httpPost("/card/invoice/setbizattr?action=get_auth_field&access_token={$this->accessToken}", '{}', false);
        if (!$result) {
            return false;
        }
        return $result['auth_field'];
    }

    /**
     * 查询开票信息
     * @param string $order_id 发票order_id
     * @param string $s_appid 发票平台的身份id
     * @return array|false
     */
    public function invoiceGetauthdata($order_id, $s_appid)
    {
        $params = [
            'order_id' => $order_id,
            's_appid' => $s_appid
        ];
        return $this->httpPost("/card/invoice/getauthdata?access_token={$this->accessToken}", $params);
    }

    /**
     * 设置开卡字段
     * @param string $card_id 卡券ID
     * @param array $extend 其他字段
     * @return array|false
     */
    public function membercardActivateuserformSet($card_id, array $extend = [])
    {
        $params = [
            'card_id' => $card_id
        ];
        $params = array_merge($params, $extend);
        return $this->httpPost("/card/membercard/activateuserform/set?access_token={$this->accessToken}", $params);
    }

    /**
     * 拉取会员信息
     * @param string $card_id 卡券ID
     * @param string $code Code码
     * @return array|false
     */
    public function membercardUserinfoGet($card_id, $code)
    {
        $params = [
            'card_id' => $card_id,
            'code' => $code
        ];
        return $this->httpPost("/card/membercard/userinfo/get?access_token={$this->accessToken}", $params);
    }

    /**
     * 更新会员信息
     * @param string $code Code码
     * @param string $card_id 卡券ID
     * @param array $extend 其他字段
     * @return array|false
     */
    public function membercardUpdateuser($code, $card_id, array $extend = [])
    {
        $params = [
            'code' => $code,
            'card_id' => $card_id
        ];
        $params = array_merge($params, $extend);
        return $this->httpPost("/card/membercard/updateuser?access_token={$this->accessToken}", $params);
    }

    /**
     * 设置支付后投放卡券
     * @param string $type 营销规则类型
     * @param array $base_info 营销规则
     * @param array|null $member_rule 支付即会员
     * @return array|false
     */
    public function paygiftcardAdd($type, array $base_info, array $member_rule = null)
    {
        $rule_info = [
            'type' => $type,
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
     * @return bool
     */
    public function paygiftcardDelete($rule_id)
    {
        $params = [
            'rule_id' => $rule_id
        ];
        $result = $this->httpPost("/card/paygiftcard/delete?access_token={$this->accessToken}", $params);
        return $result ? true : false;
    }

    /**
     * 查询支付后投放卡券规则详情
     * @param string $rule_id 支付即会员的规则名称
     * @return array|false
     */
    public function paygiftcardGetbyid($rule_id)
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
     * @return array|false
     */
    public function paygiftcardBatchget($type, $effective, $offset, $count)
    {
        $params = [
            'type' => $type,
            'effective' => $effective,
            'offset' => $offset,
            'count' => $count
        ];
        return $this->httpPost("/card/paygiftcard/batchget?access_token={$this->accessToken}", $params);
    }

    /**
     * 更新会议门票
     * @param string $code 卡券Code码
     * @param string $zone 区域
     * @param string $entrance 入口
     * @param string $seat_number 座位号
     * @param string $card_id 卡券ID
     * @param int $begin_time 开场时间戳
     * @param int $end_time 结束时间戳
     * @return bool
     */
    public function meetingticketUpdateuser($code, $zone, $entrance, $seat_number, $card_id = null, $begin_time = null, $end_time = null)
    {
        $params = [
            'code' => $code,
            'zone' => $zone,
            'entrance' => $entrance,
            'seat_number' => $seat_number,
        ];
        if (!is_null($card_id)) {
            $params['card_id'] = $card_id;
        }
        if (!is_null($begin_time)) {
            $params['begin_time'] = $begin_time;
        }
        if (!is_null($end_time)) {
            $params['end_time'] = $end_time;
        }
        $result = $this->httpPost("/card/meetingticket/updateuser?access_token={$this->accessToken}", $params);
        return $result ? true : false;
    }

    /**
     * 更新电影票
     * @param string $code 卡券Code码
     * @param string $ticket_class 电影票的类别，如2D、3D
     * @param int $show_time 电影的放映时间戳
     * @param int $duration 放映时长
     * @param string $card_id 卡券ID
     * @param string $screening_room 影厅
     * @param string $seat_number 座位号
     * @return bool
     */
    public function movieticketUpdateuser($code, $ticket_class, $show_time, $duration, $card_id = null, $screening_room = null, $seat_number = null)
    {
        $params = [
            'code' => $code,
            'ticket_class' => $ticket_class,
            'show_time' => $show_time,
            'duration' => $duration,
        ];
        if (!is_null($card_id)) {
            $params['card_id'] = $card_id;
        }
        if (!is_null($screening_room)) {
            $params['screening_room'] = $screening_room;
        }
        if (!is_null($seat_number)) {
            $params['seat_number'] = $seat_number;
        }
        $result = $this->httpPost("/card/movieticket/updateuser?access_token={$this->accessToken}", $params);
        return $result ? true : false;
    }

    /**
     * 更新飞机票信息
     * @param string $code 卡券Code码
     * @param string $etkt_bnr 电子客票号
     * @param string $class 舱等
     * @param string $card_id 卡券ID
     * @param string $qrcode_data 二维码数据
     * @param string $seat 座位号
     * @param bool $is_cancel 是否取消值机
     * @return bool
     */
    public function boardingpassCheckin($code, $etkt_bnr, $class, $card_id = null, $qrcode_data = null, $seat = null, $is_cancel = null)
    {
        $params = [
            'code' => $code,
            'etkt_bnr' => $etkt_bnr,
            'class' => $class,
        ];
        if (!is_null($card_id)) {
            $params['card_id'] = $card_id;
        }
        if (!is_null($qrcode_data)) {
            $params['qrcode_data'] = $qrcode_data;
        }
        if (!is_null($seat)) {
            $params['seat'] = $seat;
        }
        if (!is_null($is_cancel)) {
            $params['is_cancel'] = $is_cancel;
        }
        $result = $this->httpPost("/card/boardingpass/checkin?access_token={$this->accessToken}", $params);
        return $result ? true : false;
    }

    /**
     * 创建子商户
     * @param array $info 子商户信息
     * @return array|false
     */
    public function submerchantSubmit(array $info)
    {
        $params = [
            'info' => $info,
        ];
        return $this->httpPost("/card/submerchant/submit?access_token={$this->accessToken}", $params);
    }

    /**
     * 卡券开放类目查询
     * @return array|false
     */
    public function getapplyprotocol()
    {
        return $this->httpGet("/card/getapplyprotocol?access_token={$this->accessToken}");
    }

    /**
     * 更新子商户
     * @param array $info 子商户信息
     * @return array|false
     */
    public function submerchantUpdate(array $info)
    {
        $params = [
            'info' => $info,
        ];
        return $this->httpPost("/card/submerchant/update?access_token={$this->accessToken}", $params);
    }

    /**
     * 拉取单个子商户信息
     * @param string $merchant_id 子商户ID
     * @return array|false
     */
    public function submerchantGet($merchant_id)
    {
        $params = [
            'merchant_id' => $merchant_id,
        ];
        $result = $this->httpPost("/card/submerchant/get?access_token={$this->accessToken}", $params);
        if (!$result) {
            return false;
        }
        return $result['info'];
    }

    /**
     * 批量拉取子商户信息
     * @param int $begin_id 起始的子商户ID
     * @param int $limit 拉取的子商户的个数
     * @param string $status 子商户审核状态
     * @return array|false
     */
    public function submerchantBatchget($begin_id, $limit, $status = null)
    {
        $params = [
            'begin_id' => $begin_id,
            'limit' => $limit
        ];
        if(is_null($status)) {
            $params['status'] = $status;
        }
        $result = $this->httpPost("/card/submerchant/batchget?access_token={$this->accessToken}", $params);
        if (!$result) {
            return false;
        }
        return $result['info_list'];
    }
}
