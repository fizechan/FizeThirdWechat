<?php


namespace fize\third\wechat\offiaccount\message;

use fize\third\wechat\Offiaccount;

/**
 * 客服发消息
 */
class Custom extends Offiaccount
{

    const MSGTYPE_TEXT = 'text';
    const MSGTYPE_IMAGE = 'image';
    const MSGTYPE_VOICE = 'voice';
    const MSGTYPE_VIDEO = 'video';
    const MSGTYPE_MUSIC = 'music';
    const MSGTYPE_NEWS = 'news';
    const MSGTYPE_WXCARD = 'wxcard';

    public function send($touser, $msgtype, array $extend)
    {
        $params = [
            'touser' => $touser,
            'msgtype' => $msgtype,
        ];
        $params = array_merge($params, $extend);
    }
}
