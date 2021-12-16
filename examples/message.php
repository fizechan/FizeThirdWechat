<?php
require_once "../vendor/autoload.php";

use Fize\Third\Wechat\Message;
use Fize\Third\Wechat\MessageReceive;
use Fize\Third\Wechat\MessageReply;

$appId = 'wx12078319bd1c19dd';
$token = 'chenfengzhan';
$encodingaeskey = null;
$mrec = new MessageReceive($appId, $token, $encodingaeskey);
$mrec->valid();
$mrep = new MessageReply($appId, $token, $encodingaeskey);
$mrep->setFromUserName($mrec->getToUserName());
$mrep->setToUserName($mrec->getFromUserName());
switch ($mrec->getMsgType()) {
    case Message::MSGTYPE_TEXT:
        $mrep->text($mrec->getContent());
        break;
    case Message::MSGTYPE_IMAGE:
        $mrep->image($mrec->getImage()['MediaId']);
        break;
    case Message::MSGTYPE_VOICE:
        $mrep->voice($mrec->getVoice()['MediaId']);
        break;
    case Message::MSGTYPE_VIDEO:
        $mrep->video($mrec->getVideo()['MediaId'], '这是你发给我的视频', '本回应信息就是个实例，请根据实际情况进行编写。');
        break;
    case Message::MSGTYPE_SHORTVIDEO:
        $mrep->music($mrec->getShortvideo()['ThumbMediaId'], '送给你的音乐');
        break;
    case Message::MSGTYPE_LOCATION:
        $location = $mrec->getLocation();
        $mrep->text("X：{$location['Location_X']}，Y：{$location['Location_Y']}，Scale：{$location['Scale']}，Label：{$location['Label']}");
        break;
    case Message::MSGTYPE_LINK:
        $link = $mrec->getLink();
        $articles = [
            [
                'Title'       => $link['Title'],
                'Description' => $link['Description'],
                'PicUrl'      => 'http://picurl.jpg',
                'Url'         => $link['Url']
            ]
        ];
        $mrep->news($articles);
        break;
    case Message::MSGTYPE_EVENT:
        $event = $mrec->getEvent();
        switch ($event) {
            case Message::EVENT_SUBSCRIBE:
                if ($mrec->hasKey('EventKey')) {
                    $qrscene = $mrec->getQrscene();
                    $mrep->text("事件KEY值：$qrscene");
                } else {
                    $mrep->text("感谢您的关注。");
                }
                break;
            case Message::EVENT_UNSUBSCRIBE:
                // 取消关注后无法再发送消息
                syslog(LOG_INFO, "用户{$mrec->getFromUserName()}取消关注。");
                break;
            case Message::EVENT_SCAN:
                $mrep->text("事件KEY值：" . $mrec->getEventKey() . "，二维码的ticket：" . $mrec->getTicket());
                break;
            case Message::EVENT_LOCATION:
                $location = $mrec->getEventLocation();
                $mrep->text("Latitude：{$location['Latitude']}，Longitude：{$location['Longitude']}，Precision：{$location['Precision']}");
                break;
            case Message::EVENT_CLICK:
                $mrep->text("事件KEY值：" . $mrec->getEventKey());
                break;
            case Message::EVENT_VIEW:
                $mrep->text("你即将访问URL：" . $mrec->getEventKey());
                break;
            case Message::EVENT_SCANCODE_PUSH:
                $codeInfo = $mrec->getScanCodeInfo();
                $mrep->text("如果是URL则跳转访问：" . $codeInfo['ScanResult']);
                break;
            case Message::EVENT_SCANCODE_WAITMSG:
                $codeInfo = $mrec->getScanCodeInfo();
                $mrep->text("感谢等待，你的事件KEY值：" . $mrec->getEventKey() . "，二维码信息：" . $codeInfo['ScanResult']);
                break;
            case Message::EVENT_PIC_SYSPHOTO:
            case Message::EVENT_PIC_PHOTO_OR_ALBUM:
            case Message::EVENT_PIC_WEIXIN:
                $SendPicsInfo = $mrec->getSendPicsInfo();
                $mrep->text("你发送了{$SendPicsInfo['Count']}张图片");
                break;
            case Message::EVENT_LOCATION_SELECT:
                $SendLocationInfo = $mrec->getSendLocationInfo();
                $mrep->text("你的位置是X：{$SendLocationInfo['Location_X']}，Y：{$SendLocationInfo['Location_Y']}");
                break;
            case Message::EVENT_VIEW_MINIPROGRAM:
                $menuId = $mrec->getMenuID();
                $mrep->text("你点击的菜单是：$menuId");
                break;
            case Message::EVENT_TEMPLATESENDJOBFINISH:
                // 本处发送消息没有意义
                $status = $mrec->getStatus();
                if ($status == 'success') {
                    $status = '成功';
                } else {
                    $status = '失败：' . $status;
                }
                syslog(LOG_INFO, "消息ID{$mrec->getTplMsgID()}，发送结果：" . $status);
                break;
            case Message::EVENT_MASSSENDJOBFINISH:
                $massResult = $mrec->getMassResult();
                syslog(LOG_INFO, "消息ID{$massResult['MsgID']}，成功：" . $massResult['SentCount']. "，失败：" . $massResult['ErrorCount']);
                break;
            default:
                $createTime = $mrec->getCreateTime();
                $msgId = $mrec->getMsgId();
                $mrep->text("你在：$createTime 发送了信息，ID为 $msgId");
                break;
        }
}

// 输出XML
$mrep->send();