<?php


namespace fize\third\wechat\api;


use fize\third\wechat\Api;
use fize\crypt\Json;


/**
 * 微信卡券管理类
 */
class Card extends Api
{

    const URL_CARD_LOCATION_BATCHADD = '/card/location/batchadd?';
    const URL_CARD_LOCATION_BATCHGET = '/card/location/batchget?';

    const URL_CARD_GETCOLORS = '/card/getcolors?';
    const URL_CARD_CREATE = '/card/create?';
    const URL_CARD_DELETE = '/card/delete?';
    const URL_CARD_UPDATE = '/card/update?';
    const URL_CARD_BATCHGET = '/card/batchget?';
    const URL_CARD_GET = '/card/get?';

    const URL_CARD_QRCODE_CREATE = '/card/qrcode/create?';

    const URL_CARD_CODE_CONSUME = '/card/code/consume?';
    const URL_CARD_CODE_DECRYPT = '/card/code/decrypt?';
    const URL_CARD_CODE_GET = '/card/code/get?';
    const URL_CARD_CODE_UPDATE = '/card/code/update?';
    const URL_CARD_CODE_UNAVAILABLE = '/card/code/unavailable?';

    const URL_CARD_MODIFY_STOCK = '/card/modifystock?';

    const URL_CARD_MEMBERCARD_ACTIVATE = '/card/membercard/activate?';      //激活会员卡
    const URL_CARD_MEMBERCARD_UPDATEUSER = '/card/membercard/updateuser?';    //更新会员卡

    const URL_CARD_LUCKYMONEY_UPDATE = '/card/luckymoney/updateuserbalance?';     //更新红包金额

    const URL_CARD_TESTWHILELIST_SET = '/card/testwhitelist/set?';

    /**
     * 构造函数
     * @param array $p_options 参数数组
     */
    public function __construct($p_options)
    {
        parent::__construct($p_options);
        //检测TOKEN
        $this->checkAccessToken();
    }

    /**
     * 批量导入门店信息
     * @tutorial 返回插入的门店id列表，以逗号分隔。如果有插入失败的，则为-1，请自行核查是哪个插入失败
     * @param array $p_data 数组形式的json数据，由于内容较多，具体内容格式请查看 微信卡券接口文档
     * @return boolean|string 成功返回插入的门店id列表
     */
    public function addCardLocations($p_data)
    {
        $p_data = Json::encode($p_data, JSON_UNESCAPED_UNICODE);
        return $this->httpPost(self::PREFIX_API . self::URL_CARD_LOCATION_BATCHADD . 'access_token=' . $this->access_token, $p_data);
    }

    /**
     * 拉取门店列表
     * 获取在公众平台上申请创建的门店列表
     * @param int $offset 开始拉取的偏移，默认为0从头开始
     * @param int $count 拉取的数量，默认为0拉取全部
     * @return boolean|array   返回数组请参看 微信卡券接口文档 的json格式
     */
    public function getCardLocations($offset = 0, $count = 0)
    {
        $data = array(
            'offset' => $offset,
            'count'  => $count
        );
        return $this->httpPost(self::PREFIX_API . self::URL_CARD_LOCATION_BATCHGET . 'access_token=' . $this->access_token, Json::encode($data));
    }

    /**
     * 获取颜色列表
     * 获得卡券的最新颜色列表，用于创建卡券
     * @return boolean|array   返回数组请参看 微信卡券接口文档 的json格式
     */
    public function getCardColors()
    {
        return $this->httpGet(self::PREFIX_API . self::URL_CARD_GETCOLORS . 'access_token=' . $this->access_token);
    }

    /**
     * 创建卡券
     * @param array $data 卡券数据
     * @return array|boolean 返回数组中card_id为卡券ID
     */
    public function createCard(array $data)
    {
        return $this->httpPost(self::PREFIX_API . self::URL_CARD_CREATE . 'access_token=' . $this->access_token, Json::encode($data, JSON_UNESCAPED_UNICODE));
    }

    /**
     * 更改卡券信息
     * 调用该接口更新信息后会重新送审，卡券状态变更为待审核。已被用户领取的卡券会实时更新票面信息。
     * @param array $data 提交的数据
     * @return array|boolean
     */
    public function updateCard($data)
    {
        return $this->httpPost(self::PREFIX_API . self::URL_CARD_UPDATE . 'access_token=' . $this->access_token, Json::encode($data, JSON_UNESCAPED_UNICODE));
    }

    /**
     * 删除卡券
     * 允许商户删除任意一类卡券。删除卡券后，该卡券对应已生成的领取用二维码、添加到卡包 JS API 均会失效。
     * 注意：删除卡券不能删除已被用户领取，保存在微信客户端中的卡券，已领取的卡券依旧有效。
     * @param string $card_id 卡券ID
     * @return boolean
     */
    public function delCard($card_id)
    {
        $data = array(
            'card_id' => $card_id,
        );
        return $this->httpPost(self::PREFIX_API . self::URL_CARD_DELETE . 'access_token=' . $this->access_token, Json::encode($data));
    }

    /**
     * 批量查询卡列表
     * @param int $offset 开始拉取的偏移，默认为0从头开始
     * @param int $count 需要查询的卡片的数量（数量最大50,默认50）
     * @return mixed
     * {
     *  "errcode":0,
     *  "errmsg":"ok",
     *  "card_id_list":["ph_gmt7cUVrlRk8swPwx7aDyF-pg"],    //卡 id 列表
     *  "total_num":1                                       //该商户名下 card_id 总数
     * }
     */
    public function getCardIdList($offset = 0, $count = 50)
    {
        if ($count > 50) {
            $count = 50;
        }
        $data = array(
            'offset' => $offset,
            'count'  => $count,
        );
        return $this->httpPost(self::PREFIX_API . self::URL_CARD_BATCHGET . 'access_token=' . $this->access_token, Json::encode($data));
    }

    /**
     * 查询卡券详情
     * @param string $card_id
     * @return boolean|array    返回数组信息比较复杂，请参看卡券接口文档
     */
    public function getCardInfo($card_id)
    {
        $data = array(
            'card_id' => $card_id,
        );
        return $this->httpPost(self::PREFIX_API . self::URL_CARD_GET . 'access_token=' . $this->access_token, Json::encode($data));
    }

    /**
     * 生成卡券二维码
     * 成功则直接返回ticket值，可以用 getQRUrl($ticket) 换取二维码url
     * @param string $card_id 卡券ID 必须
     * @param string $code 指定卡券 code 码，只能被领一次。use_custom_code 字段为 true 的卡券必须填写，非自定义 code 不必填写。
     * @param string $openid 指定领取者的 openid，只有该用户能领取。bind_openid 字段为 true 的卡券必须填写，非自定义 openid 不必填写。
     * @param int $expire_seconds 指定二维码的有效时间，范围是 60 ~ 1800 秒。不填默认为永久有效。
     * @param boolean $is_unique_code 指定下发二维码，生成的二维码随机分配一个 code，领取后不可再次扫描。填写 true 或 false。默认 false。
     * @param string $balance 红包余额，以分为单位。红包类型必填（LUCKY_MONEY），其他卡券类型不填。
     * @param int $outer_id 领取场景值，用于领取渠道的数据统计，默认值为0
     * @return boolean|array
     */
    public function createCardQrcode($card_id, $code = '', $openid = '', $expire_seconds = 0, $is_unique_code = false, $balance = '', $outer_id = 0)
    {
        $card = array(
            'card_id' => $card_id
        );
        if ($code) {
            $card['code'] = $code;
        }
        if ($openid) {
            $card['openid'] = $openid;
        }
        if ($expire_seconds) {
            $card['expire_seconds'] = $expire_seconds;
        }
        if ($is_unique_code) {
            $card['is_unique_code'] = $is_unique_code;
        }
        if ($balance) {
            $card['balance'] = $balance;
        }
        if ($outer_id) {
            $card['outer_id'] = $outer_id;
        }
        $data = array(
            'action_name' => "QR_CARD",
            'action_info' => array('card' => $card)
        );
        return $this->httpPost(self::PREFIX_API . self::URL_CARD_QRCODE_CREATE . 'access_token=' . $this->access_token, Json::encode($data, JSON_UNESCAPED_UNICODE));
    }

    /**
     * 消耗 code
     * 自定义 code（use_custom_code 为 true）的优惠券，在 code 被核销时，必须调用此接口。
     * @param string $code 要消耗的序列号
     * @param string $card_id 要消耗序列号所述的 card_id，创建卡券时use_custom_code 填写 true 时必填。
     * @return boolean|array
     * {
     *  "errcode":0,
     *  "errmsg":"ok",
     *  "card":{"card_id":"pFS7Fjg8kV1IdDz01r4SQwMkuCKc"},
     *  "openid":"oFS7Fjl0WsZ9AMZqrI80nbIq8xrA"
     * }
     */
    public function consumeCardCode($code, $card_id = '')
    {
        $data = array('code' => $code);
        if ($card_id) {
            $data['card_id'] = $card_id;
        }
        return $this->httpPost(self::PREFIX_API . self::URL_CARD_CODE_CONSUME . 'access_token=' . $this->access_token, Json::encode($data, JSON_UNESCAPED_UNICODE));
    }

    /**
     * code 解码
     * @param string $encrypt_code 通过 choose_card_info 获取的加密字符串
     * @return boolean|array
     * {
     *  "errcode":0,
     *  "errmsg":"ok",
     *  "code":"751234212312"
     *  }
     */
    public function decryptCardCode($encrypt_code)
    {
        $data = array(
            'encrypt_code' => $encrypt_code,
        );
        return $this->httpPost(self::PREFIX_API . self::URL_CARD_CODE_DECRYPT . 'access_token=' . $this->access_token, Json::encode($data, JSON_UNESCAPED_UNICODE));
    }

    /**
     * 查询 code 的有效性（非自定义 code）
     * @param string $code
     * @return boolean|array
     * {
     *  "errcode":0,
     *  "errmsg":"ok",
     *  "openid":"oFS7Fjl0WsZ9AMZqrI80nbIq8xrA",    //用户 openid
     *  "card":{
     *      "card_id":"pFS7Fjg8kV1IdDz01r4SQwMkuCKc",
     *      "begin_time": 1404205036,               //起始使用时间
     *      "end_time": 1404205036,                 //结束时间
     *  }
     * }
     */
    public function checkCardCode($code)
    {
        $data = array(
            'code' => $code,
        );
        return $this->httpPost(self::PREFIX_API . self::URL_CARD_CODE_GET . 'access_token=' . $this->access_token, Json::encode($data, JSON_UNESCAPED_UNICODE));
    }

    /**
     * 更改 code
     * 为确保转赠后的安全性，微信允许自定义code的商户对已下发的code进行更改。
     * 注：为避免用户疑惑，建议仅在发生转赠行为后（发生转赠后，微信会通过事件推送的方式告知商户被转赠的卡券code）对用户的code进行更改。
     * @param string $code 卡券的 code 编码
     * @param string $card_id 卡券 ID
     * @param string $new_code 新的卡券 code 编码
     * @return boolean
     */
    public function updateCardCode($code, $card_id, $new_code)
    {
        $data = array(
            'code'     => $code,
            'card_id'  => $card_id,
            'new_code' => $new_code,
        );
        return $this->httpPost(self::PREFIX_API . self::URL_CARD_CODE_UPDATE . 'access_token=' . $this->access_token, Json::encode($data, JSON_UNESCAPED_UNICODE));
    }

    /**
     * 设置卡券失效
     * 设置卡券失效的操作不可逆
     * @param string $code 需要设置为失效的 code
     * @param string $card_id 自定义 code 的卡券必填。非自定义 code 的卡券不填。
     * @return boolean
     */
    public function unavailableCardCode($code, $card_id = '')
    {
        $data = array(
            'code' => $code,
        );
        if ($card_id) {
            $data['card_id'] = $card_id;
        }
        $t_rst = $this->httpPost(self::PREFIX_API . self::URL_CARD_CODE_UNAVAILABLE . 'access_token=' . $this->access_token, Json::encode($data, JSON_UNESCAPED_UNICODE));
        if ($t_rst) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 库存修改
     * @param array $data
     * @return boolean
     */
    public function modifyCardStock($data)
    {
        $t_rst = $this->httpPost(self::PREFIX_API . self::URL_CARD_MODIFY_STOCK . 'access_token=' . $this->access_token, Json::encode($data, JSON_UNESCAPED_UNICODE));
        if ($t_rst) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 激活/绑定会员卡
     * @param string $data 具体结构请参看卡券开发文档(6.1.1 激活/绑定会员卡)章节
     * @return boolean
     */
    public function activateMemberCard($data)
    {
        $t_rst = $this->httpPost(self::PREFIX_API . self::URL_CARD_MEMBERCARD_ACTIVATE . 'access_token=' . $this->access_token, Json::encode($data, JSON_UNESCAPED_UNICODE));
        if ($t_rst) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 会员卡交易
     * 会员卡交易后每次积分及余额变更需通过接口通知微信，便于后续消息通知及其他扩展功能。
     * @param string $data 具体结构请参看卡券开发文档(6.1.2 会员卡交易)章节
     * @return boolean|array
     */
    public function updateMemberCard($data)
    {
        return $this->httpPost(self::PREFIX_API . self::URL_CARD_MEMBERCARD_UPDATEUSER . 'access_token=' . $this->access_token, Json::encode($data, JSON_UNESCAPED_UNICODE));
    }

    /**
     * 更新红包金额
     * @param string $code 红包的序列号
     * @param float $balance 红包余额
     * @param string $card_id 自定义 code 的卡券必填。非自定义 code 可不填。
     * @return boolean|array
     */
    public function updateLuckyMoney($code, $balance, $card_id = '')
    {
        $data = array(
            'code'    => $code,
            'balance' => $balance
        );
        if ($card_id) {
            $data['card_id'] = $card_id;
        }
        $t_rst = $this->httpPost(self::PREFIX_API . self::URL_CARD_LUCKYMONEY_UPDATE . 'access_token=' . $this->access_token, Json::encode($data, JSON_UNESCAPED_UNICODE));
        if ($t_rst) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 设置卡券测试白名单
     * @param array $openids 测试的 openid 列表
     * @param array $users 测试的微信号列表
     * @return boolean
     */
    public function setCardTestWhiteList(array $openids = [], array $users = [])
    {
        $data = array();
        if (count($openids) > 0) {
            $data['openid'] = $openids;
        }
        if (count($users) > 0) {
            $data['username'] = $users;
        }
        $t_rst = $this->httpPost(self::PREFIX_API . self::URL_CARD_TESTWHILELIST_SET . 'access_token=' . $this->access_token, Json::encode($data, JSON_UNESCAPED_UNICODE));
        if ($t_rst) {
            return true;
        } else {
            return false;
        }
    }
}