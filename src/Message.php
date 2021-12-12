<?php

namespace Fize\Third\Wechat;

/**
 * 消息
 */
abstract class Message
{

    /**
     * 消息类型：文本消息
     */
    const MSGTYPE_TEXT = 'text';

    /**
     * 消息类型：图片消息
     */
    const MSGTYPE_IMAGE = 'image';

    /**
     * 消息类型：语音消息
     */
    const MSGTYPE_VOICE = 'voice';

    /**
     * 消息类型：视频消息
     */
    const MSGTYPE_VIDEO = 'video';

    /**
     * 消息类型：小视频消息
     */
    const MSGTYPE_SHORTVIDEO = 'shortvideo';

    /**
     * 消息类型：地理位置消息
     */
    const MSGTYPE_LOCATION = 'location';

    /**
     * 消息类型：链接消息
     */
    const MSGTYPE_LINK = 'link';

    /**
     * 消息类型：事件推送
     */
    const MSGTYPE_EVENT = 'event';

    /**
     * 消息类型：音乐消息
     */
    const MSGTYPE_MUSIC = 'music';

    /**
     * 消息类型：图文消息
     */
    const MSGTYPE_NEWS = 'news';

    const MSGTYPE_MPNEWS = 'mpnews';
    const MSGTYPE_MSGMENU = 'msgmenu';
    const MSGTYPE_WXCARD = 'wxcard';
    const MSGTYPE_MINIPROGRAMPAGE = 'miniprogrampage';

    /**
     * 消息类型：消息转发到客服
     */
    const MSGTYPE_TRANSFER_CUSTOMER_SERVICE = 'transfer_customer_service';

    /**
     * 事件类型：订阅
     */
    const EVENT_SUBSCRIBE = 'subscribe';

    /**
     * 事件类型：取消订阅
     */
    const EVENT_UNSUBSCRIBE = 'unsubscribe';

    /**
     * 事件类型：扫描带参数二维码
     */
    const EVENT_SCAN = 'SCAN';

    /**
     * 事件类型：上报地理位置
     */
    const EVENT_LOCATION = 'LOCATION';

    /**
     * 事件类型：点击菜单拉取消息
     */
    const EVENT_CLICK = 'CLICK';

    /**
     * 事件类型：点击菜单跳转链接
     */
    const EVENT_VIEW = 'VIEW';

    /**
     * 事件类型：扫码推事件(客户端跳URL)
     */
    const EVENT_SCANCODE_PUSH = 'scancode_push';

    /**
     * 事件类型：扫码推事件(客户端不跳URL)
     */
    const EVENT_SCANCODE_WAITMSG = 'scancode_waitmsg';

    /**
     * 事件类型：弹出系统拍照发图
     */
    const EVENT_PIC_SYSPHOTO = 'pic_sysphoto';

    /**
     * 事件类型：弹出拍照或者相册发图
     */
    const EVENT_PIC_PHOTO_OR_ALBUM = 'pic_photo_or_album';

    /**
     * 事件类型：弹出微信相册发图器
     */
    const EVENT_PIC_WEIXIN = 'pic_weixin';

    /**
     * 事件类型：弹出地理位置选择器
     */
    const EVENT_LOCATION_SELECT = 'location_select';

    /**
     * 事件类型：跳转小程序
     */
    const EVENT_VIEW_MINIPROGRAM = 'view_miniprogram';

    /**
     * 事件类型：模板消息发送结果
     */
    const EVENT_TEMPLATESENDJOBFINISH = 'TEMPLATESENDJOBFINISH';

    /**
     * 事件类型：事件推送群发结果
     */
    const EVENT_MASSSENDJOBFINISH = 'MASSSENDJOBFINISH';

    /**
     * 事件类型：卡券 - 审核通过
     */
    const EVENT_CARD_PASS_CHECK = 'card_pass_check';

    /**
     * 事件类型：卡券 - 审核未通过
     */
    const EVENT_CARD_NOT_PASS_CHECK = 'card_not_pass_check';

    /**
     * 事件类型：用户 - 领取卡券
     */
    const EVENT_USER_GET_CARD = 'user_get_card';

    /**
     * 事件类型：用户 - 转赠卡券
     */
    const EVENT_USER_GIFTING_CARD = 'user_gifting_card';

    /**
     * 事件类型：用户 - 删除卡券
     */
    const EVENT_USER_DEL_CARD = 'user_del_card';

    /**
     * 事件类型：用户 - 卡券被核销
     */
    const EVENT_USER_CONSUME_CARD = 'user_consume_card';

    /**
     * 事件类型：用户 - 买单
     */
    const EVENT_USER_PAY_FROM_PAY_CELL = 'user_pay_from_pay_cell';

    /**
     * 事件类型：用户 - 进入会员卡
     */
    const EVENT_USER_VIEW_CARD = 'user_view_card';

    /**
     * 事件类型：用户 - 从卡券进入公众号会话
     */
    const EVENT_USER_ENTER_SESSION_FROM_CARD = 'user_enter_session_from_card';

    /**
     * 事件类型：会员卡内容更新
     */
    const EVENT_UPDATE_MEMBER_CARD = 'update_member_card';

    /**
     * 事件类型：卡券 - 库存报警
     */
    const EVENT_CARD_SKU_REMIND = 'card_sku_remind';

    /**
     * 事件类型：卡券 - 券点流水详情
     */
    const EVENT_CARD_PAY_ORDER = 'card_pay_order';

    /**
     * 事件类型：会员卡激活
     */
    const EVENT_SUBMIT_MEMBERCARD_USER_INFO = 'submit_membercard_user_info';

    /**
     * 事件类型：订单 - 付款成功
     */
    const EVENT_MERCHANT_ORDER = 'merchant_order';

    /**
     * @var string APPID
     */
    protected $appId;

    /**
     * @var string TOKEN
     */
    protected $token;

    protected $encrypt_type;

    /**
     * @var string 加密秘钥
     */
    protected $encodingAesKey;

    /**
     * 构造
     * @param string      $appId          APPID
     * @param string      $token          TOKEN
     * @param string|null $encodingaeskey 加密秘钥
     */
    public function __construct(string $appId, string $token, string $encodingaeskey = null)
    {
        $this->appId = $appId;
        $this->token = $token;
        $this->encodingAesKey = $encodingaeskey;
    }
}
