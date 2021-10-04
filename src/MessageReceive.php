<?php


namespace fize\third\wechat;

use fize\third\wechat\Prpcrypt;
use OutOfBoundsException;


/**
 * 微信信息接收类
 *
 * 本接口非微信直接提供
 */
class MessageReceive extends Message
{
    private $postXml;

    /**
     * @var array 消息体
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
            $array = (array)Simplexml::loadString($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $this->encrypt_type = $_GET["encrypt_type"] ?? '';
            if ($this->encrypt_type == 'aes') { //aes加密
                //Log::write($postStr);
                $encryptStr = $array['Encrypt'];
                $pc = new Prpcrypt($this->encodingAesKey);
                $array = $pc->decrypt($encryptStr, $this->appid);
                if (!isset($array[0]) || ($array[0] != 0)) {
                    if (!$return) {
                        die('decrypt error!');
                    } else {
                        return false;
                    }
                }
                $this->postXml = $array[1];
                if (!$this->appid) {
                    //为了没有appid的订阅号。
                    $this->appid = $array[2];
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
    public function messageHasKey(string $key): bool
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
        return $this->getMessageKeyValue('ToUserName');
    }

    /**
     * 获取发送方帐号（一个OpenID）
     * @return string
     */
    public function getFromUserName(): string
    {
        return $this->getMessageKeyValue('FromUserName');
    }

    /**
     * 获取消息创建时间
     * @return int
     */
    public function getCreateTime(): int
    {
        return (int)$this->getMessageKeyValue('CreateTime');
    }

    /**
     * 获取消息类型
     * @return string
     */
    public function getMsgType(): string
    {
        return $this->getMessageKeyValue('MsgType');
    }

    /**
     * 获取消息ID
     * @return string
     */
    public function getMsgId(): string
    {
        return $this->getMessageKeyValue('MsgId');
    }

    /**
     * 获取文本消息
     * @return string
     */
    public function getContent(): string
    {
        return $this->getMessageKeyValue('Content');
    }

    /**
     * 获取图片消息
     * @return array ['PicUrl' => *, 'MediaId' => *]
     */
    public function getImage(): array
    {
        return [
            'PicUrl'  => $this->getMessageKeyValue('PicUrl'),
            'MediaId' => $this->getMessageKeyValue('MediaId')
        ];
    }

    /**
     * 获取语音消息
     * @return array ['MediaId' => *, 'Format' => *]
     */
    public function getVoice(): array
    {
        return [
            'MediaId' => $this->getMessageKeyValue('MediaId'),
            'Format'  => $this->getMessageKeyValue('Format')
        ];
    }

    /**
     * 获取视频消息
     * @return array ['MediaId' => *, 'ThumbMediaId' => *]
     */
    public function getVideo(): array
    {
        return [
            'MediaId'      => $this->getMessageKeyValue('MediaId'),
            'ThumbMediaId' => $this->getMessageKeyValue('ThumbMediaId')
        ];
    }

    /**
     * 获取小视频消息
     * @return array ['MediaId' => *, 'ThumbMediaId' => *]
     */
    public function getShortvideo(): array
    {
        return [
            'MediaId'      => $this->getMessageKeyValue('MediaId'),
            'ThumbMediaId' => $this->getMessageKeyValue('ThumbMediaId')
        ];
    }

    /**
     * 获取地理位置消息
     * @return array ['Location_X' => *, 'Location_Y' => *, 'Scale' => *, 'Label' => *]
     */
    public function getLocation(): array
    {
        return [
            'Location_X' => $this->getMessageKeyValue('Location_X'),
            'Location_Y' => $this->getMessageKeyValue('Location_Y'),
            'Scale'      => $this->getMessageKeyValue('Scale'),
            'Label'      => $this->getMessageKeyValue('Label')
        ];
    }

    /**
     * 获取链接消息
     * @return array ['Title' => *, 'Description' => *, 'Url' => *]
     */
    public function getLink(): array
    {
        return [
            'Title'       => $this->getMessageKeyValue('Title'),
            'Description' => $this->getMessageKeyValue('Description'),
            'Url'         => $this->getMessageKeyValue('Url')
        ];
    }

    /**
     * 获取接收事件推送
     * @return string
     */
    public function getEvent(): string
    {
        return $this->getMessageKeyValue('Event');
    }

    /**
     * 获取接收二维码TICKET
     */
    public function getRevTicket()
    {
        if (isset($this->message['Ticket'])) {
            return $this->message['Ticket'];
        } else {
            return false;
        }
    }

    /**
     * 获取二维码的场景值
     */
    public function getRevSceneId()
    {
        if (isset($this->message['EventKey'])) {
            return str_replace('qrscene_', '', $this->message['EventKey']);
        } else {
            return false;
        }
    }

    /**
     * 获取上报地理位置事件
     */
    public function getRevEventGeo()
    {
        if (isset($this->message['Latitude'])) {
            return [
                'x'         => $this->message['Latitude'],
                'y'         => $this->message['Longitude'],
                'precision' => $this->message['Precision'],
            ];
        } else {
            return false;
        }
    }

    /**
     * 获取自定义菜单的扫码推事件信息
     *
     * 事件类型为以下两种时则调用此方法有效
     * Event     事件类型，scancode_push
     * Event     事件类型，scancode_waitmsg
     *
     * @return mixed
     * array (
     *     'ScanType'=>'qrcode',
     *     'ScanResult'=>'123123'
     * )
     */
    public function getRevScanInfo()
    {
        if (isset($this->message['ScanCodeInfo'])) {
            if (!is_array($this->message['ScanCodeInfo'])) {
                $array = (array)$this->message['ScanCodeInfo'];
                $this->message['ScanCodeInfo'] = $array;
            } else {
                $array = $this->message['ScanCodeInfo'];
            }
        }
        if (isset($array) && count($array) > 0) {
            return $array;
        } else {
            return false;
        }
    }

    /**
     * 获取自定义菜单的图片发送事件信息
     *
     * 事件类型为以下三种时则调用此方法有效
     * Event     事件类型，pic_sysphoto        弹出系统拍照发图的事件推送
     * Event     事件类型，pic_photo_or_album  弹出拍照或者相册发图的事件推送
     * Event     事件类型，pic_weixin          弹出微信相册发图器的事件推送
     *
     * @return mixed
     * array (
     *   'Count' => '2',
     *   'PicList' =>array (
     *         'item' =>array (
     *             0 =>array ('PicMd5Sum' => 'aaae42617cf2a14342d96005af53624c'),
     *             1 =>array ('PicMd5Sum' => '149bd39e296860a2adc2f1bb81616ff8'),
     *         ),
     *   ),
     * )
     *
     */
    public function getRevSendPicsInfo()
    {
        if (isset($this->message['SendPicsInfo'])) {
            if (!is_array($this->message['SendPicsInfo'])) {
                $array = (array)$this->message['SendPicsInfo'];
                if (isset($array['PicList'])) {
                    $array['PicList'] = (array)$array['PicList'];
                    $item = $array['PicList']['item'];
                    $array['PicList']['item'] = [];
                    foreach ($item as $key => $value) {
                        $array['PicList']['item'][$key] = (array)$value;
                    }
                }
                $this->message['SendPicsInfo'] = $array;
            } else {
                $array = $this->message['SendPicsInfo'];
            }
        }
        if (isset($array) && count($array) > 0) {
            return $array;
        } else {
            return false;
        }
    }

    /**
     * 获取自定义菜单的地理位置选择器事件推送
     *
     * 事件类型为以下时则可以调用此方法有效
     * Event     事件类型，location_select        弹出地理位置选择器的事件推送
     *
     * @return mixed
     * array (
     *   'Location_X' => '33.731655000061',
     *   'Location_Y' => '113.29955200008047',
     *   'Scale' => '16',
     *   'Label' => '某某市某某区某某路',
     *   'Poiname' => '',
     * )
     *
     */
    public function getRevSendGeoInfo()
    {
        if (isset($this->message['SendLocationInfo'])) {
            if (!is_array($this->message['SendLocationInfo'])) {
                $array = (array)$this->message['SendLocationInfo'];
                if (empty($array['Poiname'])) {
                    $array['Poiname'] = "";
                }
                if (empty($array['Label'])) {
                    $array['Label'] = "";
                }
                $this->message['SendLocationInfo'] = $array;
            } else {
                $array = $this->message['SendLocationInfo'];
            }
        }
        if (isset($array) && count($array) > 0) {
            return $array;
        } else {
            return false;
        }
    }

    /**
     * 获取主动推送的消息ID
     * 经过验证，这个和普通的消息MsgId不一样
     * 当Event为 MASSSENDJOBFINISH 或 TEMPLATESENDJOBFINISH
     */
    public function getRevTplMsgID()
    {
        if (isset($this->message['MsgID'])) {
            return $this->message['MsgID'];
        } else {
            return false;
        }
    }

    /**
     * 获取模板消息发送状态
     */
    public function getRevStatus()
    {
        if (isset($this->message['Status'])) {
            return $this->message['Status'];
        } else {
            return false;
        }
    }

    /**
     * 获取群发或模板消息发送结果
     * 当Event为 MASSSENDJOBFINISH 或 TEMPLATESENDJOBFINISH，即高级群发/模板消息
     */
    public function getRevResult()
    {
        if (isset($this->message['Status'])) //发送是否成功，具体的返回值请参考 高级群发/模板消息 的事件推送说明
            $array['Status'] = $this->message['Status'];
        if (isset($this->message['MsgID'])) //发送的消息id
            $array['MsgID'] = $this->message['MsgID'];

        //以下仅当群发消息时才会有的事件内容
        if (isset($this->message['TotalCount']))     //分组或openid列表内粉丝数量
            $array['TotalCount'] = $this->message['TotalCount'];
        if (isset($this->message['FilterCount']))    //过滤（过滤是指特定地区、性别的过滤、用户设置拒收的过滤，用户接收已超4条的过滤）后，准备发送的粉丝数
            $array['FilterCount'] = $this->message['FilterCount'];
        if (isset($this->message['SentCount']))     //发送成功的粉丝数
            $array['SentCount'] = $this->message['SentCount'];
        if (isset($this->message['ErrorCount']))    //发送失败的粉丝数
            $array['ErrorCount'] = $this->message['ErrorCount'];
        if (isset($array) && count($array) > 0) {
            return $array;
        } else {
            return false;
        }
    }

    /**
     * 获取多客服会话状态推送事件 - 接入会话
     * 当Event为 kfcreatesession 即接入会话
     * @return string | boolean  返回分配到的客服
     */
    public function getRevKfCreate()
    {
        if (isset($this->message['KfAccount'])) {
            return $this->message['KfAccount'];
        } else {
            return false;
        }
    }

    /**
     * 获取多客服会话状态推送事件 - 关闭会话
     * 当Event为 kfclosesession 即关闭会话
     * @return string | boolean  返回分配到的客服
     */
    public function getRevKfClose()
    {
        if (isset($this->message['KfAccount'])) {
            return $this->message['KfAccount'];
        } else {
            return false;
        }
    }

    /**
     * 获取多客服会话状态推送事件 - 转接会话
     * 当Event为 kfswitchsession 即转接会话
     * @return array | boolean  返回分配到的客服
     * {
     *     'FromKfAccount' => '',      //原接入客服
     *     'ToKfAccount' => ''            //转接到客服
     * }
     */
    public function getRevKfSwitch()
    {
        if (isset($this->message['FromKfAccount']))     //原接入客服
            $array['FromKfAccount'] = $this->message['FromKfAccount'];
        if (isset($this->message['ToKfAccount']))    //转接到客服
            $array['ToKfAccount'] = $this->message['ToKfAccount'];
        if (isset($array) && count($array) > 0) {
            return $array;
        } else {
            return false;
        }
    }

    /**
     * 获取卡券事件推送 - 卡卷审核是否通过
     * 当Event为 card_pass_check(审核通过) 或 card_not_pass_check(未通过)
     * @return string|boolean  返回卡券ID
     */
    public function getRevCardPass()
    {
        if (isset($this->message['CardId']))
            return $this->message['CardId'];
        else {
            return false;
        }
    }

    /**
     * 获取卡券事件推送 - 领取卡券
     * 当Event为 user_get_card(用户领取卡券)
     * @return array|boolean
     */
    public function getRevCardGet()
    {
        if (isset($this->message['CardId'])) {
            //卡券 ID
            $array['CardId'] = $this->message['CardId'];
        }
        if (isset($this->message['IsGiveByFriend'])) {
            //是否为转赠，1 代表是，0 代表否。
            $array['IsGiveByFriend'] = $this->message['IsGiveByFriend'];
        }
        if (isset($this->message['UserCardCode']) && !empty($this->message['UserCardCode'])) {
            //code 序列号。自定义 code 及非自定义 code的卡券被领取后都支持事件推送。
            $array['UserCardCode'] = $this->message['UserCardCode'];
        }
        if (isset($array) && count($array) > 0) {
            return $array;
        } else {
            return false;
        }
    }

    /**
     * 获取卡券事件推送 - 删除卡券
     * 当Event为 user_del_card(用户删除卡券)
     * @return array|boolean
     */
    public function getRevCardDel()
    {
        if (isset($this->message['CardId'])) {
            //卡券 ID
            $array['CardId'] = $this->message['CardId'];
        }
        if (isset($this->message['UserCardCode']) && !empty($this->message['UserCardCode'])) {
            //code 序列号。自定义 code 及非自定义 code的卡券被领取后都支持事件推送。
            $array['UserCardCode'] = $this->message['UserCardCode'];
        }
        if (isset($array) && count($array) > 0) {
            return $array;
        } else {
            return false;
        }
    }

    /**
     * 获取接收消息内容正文
     */
    public function getRevContent()
    {
        if (isset($this->message['Content'])) {
            return $this->message['Content'];
        } else if (isset($this->message['Recognition'])) {
            //获取语音识别文字内容，需申请开通
            return $this->message['Recognition'];
        } else {
            return false;
        }
    }

    /**
     * 获取标签值
     * @param string $key 标签名
     * @return array|string
     */
    protected function getMessageKeyValue(string $key)
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
