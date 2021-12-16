<?php

namespace Fize\Third\Wechat;

use OutOfBoundsException;

/**
 * 微信信息接收类
 *
 * 本接口非微信直接提供
 */
class MessageReceive extends Message
{

    /**
     * @var string XML消息体
     */
    private $postXml;

    /**
     * @var array 数组消息体
     */
    private $message;

    /**
     * 微信验证，包括post来的xml解密
     * @param bool $return
     * @return boolean
     */
    public function valid($return = false)
    {
        $encryptStr = "";
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $postStr = file_get_contents("php://input");
            $array = (array)simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $this->encrypt_type = $_GET["encrypt_type"] ?? '';
            if ($this->encrypt_type == 'aes') { //aes加密
                //Log::write($postStr);
                $encryptStr = $array['Encrypt'];
                $pc = new Prpcrypt($this->encodingAesKey);
                $array = $pc->decrypt($encryptStr, $this->appId);
                if (!isset($array[0]) || ($array[0] != 0)) {
                    if (!$return) {
                        die('decrypt error!');
                    } else {
                        return false;
                    }
                }
                $this->postXml = $array[1];
                if (!$this->appId) {
                    // 为了没有appid的订阅号。
                    $this->appId = $array[2];
                }
            } else {
                $this->postXml = $postStr;
            }
        } elseif (isset($_GET["echostr"])) {
            $echoStr = $_GET["echostr"];
            if ($return) {
                if ($this->checkSignature('')) {
                    return $echoStr;
                } else {
                    return false;
                }
            } else {
                if ($this->checkSignature('')) {
                    die($echoStr);
                } else {
                    die('no access');
                }
            }
        }
        if (!$this->checkSignature($encryptStr)) {
            if ($return) {
                return false;
            } else {
                die('no access');
            }
        }
        return true;
    }

    /**
     * 获取微信服务器发来的信息
     * @return array
     */
    public function get(): array
    {
        if ($this->message) {
            return $this->message;
        }
        $postXml = !empty($this->postXml) ? $this->postXml : file_get_contents("php://input");  // 兼顾使用明文又不想调用valid()方法的情况
        if (!empty($postXml)) {
            $this->message = $this->xmlToArray($postXml);
        }
        return $this->message;
    }

    /**
     * 判断消息体是否含有指定字段
     * @param string $key 字段名
     * @return bool
     */
    public function hasKey(string $key): bool
    {
        $message = $this->get();
        return isset($message[$key]);
    }

    /**
     * 获取接收者(开发者微信号)
     * @return string
     */
    public function getToUserName(): string
    {
        return $this->getKeyValue('ToUserName');
    }

    /**
     * 获取发送方帐号（一个OpenID）
     * @return string
     */
    public function getFromUserName(): string
    {
        return $this->getKeyValue('FromUserName');
    }

    /**
     * 获取消息创建时间
     * @return int
     */
    public function getCreateTime(): int
    {
        return (int)$this->getKeyValue('CreateTime');
    }

    /**
     * 获取消息类型
     * @return string
     */
    public function getMsgType(): string
    {
        return $this->getKeyValue('MsgType');
    }

    /**
     * 获取消息ID
     * @return string
     */
    public function getMsgId(): string
    {
        return $this->getKeyValue('MsgId');
    }

    /**
     * 获取文本消息
     * @return string
     */
    public function getContent(): string
    {
        return $this->getKeyValue('Content');
    }

    /**
     * 获取图片消息
     * @return array ['PicUrl' => *, 'MediaId' => *]
     */
    public function getImage(): array
    {
        return [
            'PicUrl'  => $this->getKeyValue('PicUrl'),
            'MediaId' => $this->getKeyValue('MediaId')
        ];
    }

    /**
     * 获取语音消息
     * @return array ['MediaId' => *, 'Format' => *]
     */
    public function getVoice(): array
    {
        return [
            'MediaId' => $this->getKeyValue('MediaId'),
            'Format'  => $this->getKeyValue('Format')
        ];
    }

    /**
     * 获取视频消息
     * @return array ['MediaId' => *, 'ThumbMediaId' => *]
     */
    public function getVideo(): array
    {
        return [
            'MediaId'      => $this->getKeyValue('MediaId'),
            'ThumbMediaId' => $this->getKeyValue('ThumbMediaId')
        ];
    }

    /**
     * 获取小视频消息
     * @return array ['MediaId' => *, 'ThumbMediaId' => *]
     */
    public function getShortvideo(): array
    {
        return [
            'MediaId'      => $this->getKeyValue('MediaId'),
            'ThumbMediaId' => $this->getKeyValue('ThumbMediaId')
        ];
    }

    /**
     * 获取地理位置消息
     * @return array ['Location_X' => *, 'Location_Y' => *, 'Scale' => *, 'Label' => *]
     */
    public function getLocation(): array
    {
        return [
            'Location_X' => $this->getKeyValue('Location_X'),
            'Location_Y' => $this->getKeyValue('Location_Y'),
            'Scale'      => $this->getKeyValue('Scale'),
            'Label'      => $this->getKeyValue('Label')
        ];
    }

    /**
     * 获取链接消息
     * @return array ['Title' => *, 'Description' => *, 'Url' => *]
     */
    public function getLink(): array
    {
        return [
            'Title'       => $this->getKeyValue('Title'),
            'Description' => $this->getKeyValue('Description'),
            'Url'         => $this->getKeyValue('Url')
        ];
    }

    /**
     * 获取接收事件推送
     * @return string
     */
    public function getEvent(): string
    {
        return $this->getKeyValue('Event');
    }

    /**
     * 获取事件KEY值
     * @return string
     */
    public function getEventKey(): string
    {
        return $this->getKeyValue('EventKey');
    }

    /**
     * 获取二维码的场景值
     * @return string
     */
    public function getQrscene(): string
    {
        return str_replace('qrscene_', '', $this->getEventKey());
    }

    /**
     * 获取接收二维码TICKET
     * @return string
     */
    public function getTicket(): string
    {
        return $this->getKeyValue('Ticket');
    }


    /**
     * 获取上报地理位置事件
     * @return array ['Latitude' => *, 'Longitude' => *, 'Precision' => *]
     */
    public function getEventLocation(): array
    {
        return [
            'Latitude'  => $this->getKeyValue('Latitude'),
            'Longitude' => $this->getKeyValue('Longitude'),
            'Precision' => $this->getKeyValue('Precision')
        ];
    }

    /**
     * 获取主动推送的消息ID
     *
     * 经过验证，这个和普通的消息MsgId不一样
     * 当Event为 MASSSENDJOBFINISH 或 TEMPLATESENDJOBFINISH
     * @return string
     */
    public function getTplMsgID(): string
    {
        return $this->getKeyValue('MsgID');
    }

    /**
     * 获取模板消息发送状态
     * @return string
     */
    public function getStatus(): string
    {
        return $this->getKeyValue('Status');
    }

    /**
     * 获取群发或模板消息发送结果
     * @return array ['MsgID' => *, 'Status' => *, 'TotalCount' => *, 'FilterCount' => *, 'SentCount' => *, 'ErrorCount' => *, 'CopyrightCheckResult' => *]
     */
    public function getMassResult(): array
    {
        return [
            'MsgID'                => $this->getKeyValue('MsgID'),
            'Status'               => $this->getKeyValue('Status'),
            'TotalCount'           => $this->getKeyValue('TotalCount'),
            'FilterCount'          => $this->getKeyValue('FilterCount'),
            'SentCount'            => $this->getKeyValue('SentCount'),
            'ErrorCount'           => $this->getKeyValue('ErrorCount'),
            'CopyrightCheckResult' => $this->getKeyValue('CopyrightCheckResult'),
        ];
    }

    /**
     * 获取自定义菜单的扫码推事件信息
     * @return array ['ScanType' => *, 'ScanResult' => *]
     */
    public function getScanCodeInfo(): array
    {
        return $this->getKeyValue('ScanCodeInfo');
    }

    /**
     * 获取自定义菜单的图片发送事件信息
     *
     * 事件类型为以下三种时则调用此方法有效
     * Event     事件类型，pic_sysphoto        弹出系统拍照发图的事件推送
     * Event     事件类型，pic_photo_or_album  弹出拍照或者相册发图的事件推送
     * Event     事件类型，pic_weixin          弹出微信相册发图器的事件推送
     * @return array ['Count' => *, 'PicList' => *]
     */
    public function getSendPicsInfo(): array
    {
        return $this->getKeyValue('SendPicsInfo');
    }

    /**
     * 获取自定义菜单的地理位置选择器事件推送
     *
     * 事件类型为以下时则可以调用此方法有效
     * Event     事件类型，location_select        弹出地理位置选择器的事件推送
     * @return array ['Location_X' => *, 'Location_Y' => *, 'Scale' => *, 'Label' => *, 'Poiname' => *]
     */
    public function getSendLocationInfo(): array
    {
        return $this->getKeyValue('SendLocationInfo');
    }

    /**
     * 获取菜单ID
     * @return string
     */
    public function getMenuID(): string
    {
        return $this->getKeyValue('MenuID');
    }

    /**
     * 获取卡券ID
     * 当Event为 card_pass_check(审核通过) 或 card_not_pass_check(未通过)
     * @return string  返回卡券ID
     */
    public function getCardId(): string
    {
        return $this->getKeyValue('CardId');
    }

    /**
     * 获取卡券审核不通过原因
     * 当Event为 card_not_pass_check(未通过)
     * @return string  返回审核不通过原因
     */
    public function getRefuseReason(): string
    {
        return $this->getKeyValue('RefuseReason');
    }

    /**
     * 获取卡券事件推送 - 领取卡券
     * 当Event为 user_get_card(用户领取卡券)
     * @return array ['CardId' => *, 'IsGiveByFriend' => *, 'UserCardCode' => *, 'FriendUserName' => *, 'OuterId' => *, 'OldUserCardCode' => *, 'OuterStr' => *, 'IsRestoreMemberCard' => *, 'IsRecommendByFriend' => *, 'UnionId' => *]
     */
    public function getUserGetCard(): array
    {
        return [
            'CardId'              => $this->getKeyValue('CardId'),
            'IsGiveByFriend'      => $this->getKeyValue('IsGiveByFriend'),
            'UserCardCode'        => $this->getKeyValue('UserCardCode'),
            'FriendUserName'      => $this->getKeyValue('FriendUserName'),
            'OuterId'             => $this->getKeyValue('OuterId'),
            'OldUserCardCode'     => $this->getKeyValue('OldUserCardCode'),
            'OuterStr'            => $this->getKeyValue('OuterStr'),
            'IsRestoreMemberCard' => $this->getKeyValue('IsRestoreMemberCard'),
            'IsRecommendByFriend' => $this->getKeyValue('IsRecommendByFriend'),
            'UnionId'             => $this->getKeyValue('UnionId')
        ];
    }

    /**
     * 获取卡券事件推送 - 转赠卡券
     * 当Event为 user_gifting_card(用户转赠卡券)
     * @return array
     */
    public function getUserGiftingCard(): array
    {
        return [
            'CardId'         => $this->getKeyValue('CardId'),
            'UserCardCode'   => $this->getKeyValue('UserCardCode'),
            'IsReturnBack'   => $this->getKeyValue('IsReturnBack'),
            'FriendUserName' => $this->getKeyValue('FriendUserName'),
            'IsChatRoom'     => $this->getKeyValue('IsChatRoom')
        ];
    }

    /**
     * 获取卡券事件推送 - 删除卡券
     * 当Event为 user_del_card(用户删除卡券)
     * @return array
     */
    public function getUserDelCard(): array
    {
        return [
            'CardId'       => $this->getKeyValue('CardId'),
            'UserCardCode' => $this->getKeyValue('UserCardCode')
        ];
    }

    /**
     * 获取卡券事件推送 - 卡券被核销
     * 当Event为 user_consume_card(卡券被核销)
     * @return array
     */
    public function getUserConsumeCard(): array
    {
        return [
            'CardId'        => $this->getKeyValue('CardId'),
            'UserCardCode'  => $this->getKeyValue('UserCardCode'),
            'ConsumeSource' => $this->getKeyValue('ConsumeSource'),
            'LocationName'  => $this->getKeyValue('LocationName'),
            'StaffOpenId'   => $this->getKeyValue('StaffOpenId'),
            'VerifyCode'    => $this->getKeyValue('VerifyCode'),
            'RemarkAmount'  => $this->getKeyValue('RemarkAmount'),
            'OuterStr'      => $this->getKeyValue('OuterStr')
        ];
    }

    /**
     * 获取买单事件推送
     * 当Event为 user_pay_from_pay_cell(买单事件推送)
     * @return array
     */
    public function getUserPayFromPayCell(): array
    {
        return [
            'CardId'       => $this->getKeyValue('CardId'),
            'UserCardCode' => $this->getKeyValue('UserCardCode'),
            'TransId'      => $this->getKeyValue('TransId'),
            'LocationId'   => $this->getKeyValue('LocationId'),
            'Fee'          => $this->getKeyValue('Fee'),
            'OriginalFee'  => $this->getKeyValue('OriginalFee')
        ];
    }

    /**
     * 获取进入会员卡事件推送
     * 当Event为 user_view_card(进入会员卡)
     * @return array
     */
    public function getUserViewCard(): array
    {
        return [
            'CardId'       => $this->getKeyValue('CardId'),
            'UserCardCode' => $this->getKeyValue('UserCardCode'),
            'OuterStr'     => $this->getKeyValue('OuterStr')
        ];
    }

    /**
     * 获取从卡券进入公众号会话事件推送
     * 当Event为 user_enter_session_from_card(进入会员卡)
     * @return array
     */
    public function getUserEnterSessionFromCard(): array
    {
        return [
            'CardId'       => $this->getKeyValue('CardId'),
            'UserCardCode' => $this->getKeyValue('UserCardCode')
        ];
    }

    /**
     * 获取会员卡内容更新事件
     * 当Event为 update_member_card(会员卡内容更新)
     * @return array
     */
    public function getUpdateMemberCard(): array
    {
        return [
            'CardId'        => $this->getKeyValue('CardId'),
            'UserCardCode'  => $this->getKeyValue('UserCardCode'),
            'ModifyBonus'   => $this->getKeyValue('ModifyBonus'),
            'ModifyBalance' => $this->getKeyValue('ModifyBalance')
        ];
    }

    /**
     * 获取库存报警事件
     * 当Event为 card_sku_remind(库存报警)
     * @return array
     */
    public function getCardSkuRemind(): array
    {
        return [
            'CardId' => $this->getKeyValue('CardId'),
            'Detail' => $this->getKeyValue('Detail')
        ];
    }

    /**
     * 获取券点流水详情事件
     * 当Event为 card_pay_order(券点流水详情)
     * @return array
     */
    public function getCardPayOrder(): array
    {
        return [
            'OrderId'             => $this->getKeyValue('OrderId'),
            'Status'              => $this->getKeyValue('Status'),
            'CreateOrderTime'     => $this->getKeyValue('CreateOrderTime'),
            'PayFinishTime'       => $this->getKeyValue('PayFinishTime'),
            'Desc'                => $this->getKeyValue('Desc'),
            'FreeCoinCount'       => $this->getKeyValue('FreeCoinCount'),
            'PayCoinCount'        => $this->getKeyValue('PayCoinCount'),
            'RefundFreeCoinCount' => $this->getKeyValue('RefundFreeCoinCount'),
            'RefundPayCoinCount'  => $this->getKeyValue('RefundPayCoinCount'),
            'OrderType'           => $this->getKeyValue('OrderType'),
            'Memo'                => $this->getKeyValue('Memo'),
            'ReceiptInfo'         => $this->getKeyValue('ReceiptInfo')
        ];
    }

    /**
     * 获取会员卡激活事件
     * 当Event为 submit_membercard_user_info(会员卡激活)
     * @return array
     */
    public function getSubmitMembercardUserInfo(): array
    {
        return [
            'CardId'       => $this->getKeyValue('CardId'),
            'UserCardCode' => $this->getKeyValue('UserCardCode')
        ];
    }

    /**
     * 获取标签值
     * @param string $key 标签名
     * @return array|string
     */
    protected function getKeyValue(string $key)
    {
        $message = $this->get();
        if (!isset($message[$key])) {
            throw new OutOfBoundsException("XML消息体不存在标签$key");
        }
        return $message[$key];
    }

    /**
     * 将XML转为array
     * @param string $xml XML字符串
     * @return array
     */
    protected function xmlToArray(string $xml): array
    {
        libxml_disable_entity_loader(true);  // 禁止引用外部xml实体
        return json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
    }

    /**
     * 验证信息是否来自微信服务器
     * @param string $str 消息体
     * @return bool
     */
    protected function checkSignature(string $str): bool
    {
        $signature = $_GET["signature"] ?? '';
        $signature = $_GET["msg_signature"] ?? $signature;  // 如果存在加密验证则用加密验证段
        $timestamp = $_GET["timestamp"] ?? '';
        $nonce = $_GET["nonce"] ?? '';

        $token = $this->token;
        $tmpArr = [$token, $timestamp, $nonce, $str];
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);

        if ($tmpStr == $signature) {
            return true;
        } else {
            return false;
        }
    }
}
