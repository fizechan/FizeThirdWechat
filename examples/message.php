<?php
require_once "../vendor/autoload.php";

use fize\third\wechat\Message;
use fize\third\wechat\MessageReceive;
use fize\third\wechat\MessageReply;

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
}

// 输出XML
$xml = $mrep->xml();
echo $xml;