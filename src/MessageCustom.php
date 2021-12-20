<?php

namespace Fize\Third\Wechat;

use Fize\Third\Wechat\Api\Message\Custom;

/**
 * 客服发消息
 */
class MessageCustom extends Custom
{
    /**
     * 发送文本消息
     * @param string      $touser     接收用户OPENID
     * @param string      $content    文本内容
     * @param string|null $kf_account 指定客服帐号
     */
    public function sendText(string $touser, string $content, string $kf_account = null)
    {
        $extend = [
            'text' => [
                'content' => $content
            ]
        ];
        $this->send($touser, Message::MSGTYPE_TEXT, $extend, $kf_account);
    }

    /**
     * 发送图片消息
     * @param string      $touser     接收用户OPENID
     * @param string      $media_id   图片素材ID
     * @param string|null $kf_account 指定客服帐号
     */
    public function sendImage(string $touser, string $media_id, string $kf_account = null)
    {
        $extend = [
            'image' => [
                'media_id' => $media_id
            ]
        ];
        $this->send($touser, Message::MSGTYPE_IMAGE, $extend, $kf_account);
    }

    /**
     * 发送语音消息
     * @param string      $touser     接收用户OPENID
     * @param string      $media_id   语音素材ID
     * @param string|null $kf_account 指定客服帐号
     */
    public function sendVoice(string $touser, string $media_id, string $kf_account = null)
    {
        $extend = [
            'voice' => [
                'media_id' => $media_id
            ]
        ];
        $this->send($touser, Message::MSGTYPE_VOICE, $extend, $kf_account);
    }

    /**
     * 发送视频消息
     * @param string      $touser         接收用户OPENID
     * @param string      $media_id       视频素材ID
     * @param string      $thumb_media_id 缩略图素材ID
     * @param string      $title          标题
     * @param string      $description    简介
     * @param string|null $kf_account     指定客服帐号
     */
    public function sendVideo(string $touser, string $media_id, string $thumb_media_id, string $title, string $description, string $kf_account = null)
    {
        $extend = [
            'video' => [
                'media_id'       => $media_id,
                'thumb_media_id' => $thumb_media_id,
                'title'          => $title,
                'description'    => $description,
            ]
        ];
        $this->send($touser, Message::MSGTYPE_VIDEO, $extend, $kf_account);
    }

    /**
     * 发送音乐消息
     * @param string      $touser         接收用户OPENID
     * @param string      $title          标题
     * @param string      $description    简介
     * @param string      $musicurl       音乐URL
     * @param string      $hqmusicurl     高品质音乐URL
     * @param string      $thumb_media_id 缩略图素材ID
     * @param string|null $kf_account     指定客服帐号
     */
    public function sendMusic(string $touser, string $title, string $description, string $musicurl, string $hqmusicurl, string $thumb_media_id, string $kf_account = null)
    {
        $extend = [
            'video' => [
                'title'          => $title,
                'description'    => $description,
                'musicurl'       => $musicurl,
                'hqmusicurl'     => $hqmusicurl,
                'thumb_media_id' => $thumb_media_id,
            ]
        ];
        $this->send($touser, Message::MSGTYPE_MUSIC, $extend, $kf_account);
    }

    /**
     * 发送图文消息（点击跳转到外链）
     * @param string      $touser     接收用户OPENID
     * @param array       $articles   图文消息
     * @param string|null $kf_account 指定客服帐号
     */
    public function sendNews(string $touser, array $articles, string $kf_account = null)
    {
        $extend = [
            'news' => [
                'articles' => $articles,
            ]
        ];
        $this->send($touser, Message::MSGTYPE_NEWS, $extend, $kf_account);
    }

    /**
     * 发送图文消息（点击跳转到图文消息页面）
     * @param string      $touser     接收用户OPENID
     * @param string      $media_id   图文素材ID
     * @param string|null $kf_account 指定客服帐号
     */
    public function sendMpnews(string $touser, string $media_id, string $kf_account = null)
    {
        $extend = [
            'mpnews' => [
                'media_id' => $media_id,
            ]
        ];
        $this->send($touser, Message::MSGTYPE_MPNEWS, $extend, $kf_account);
    }

    /**
     * 发送菜单消息
     * @param string      $touser       接收用户OPENID
     * @param string      $head_content 头部内容
     * @param array       $list         选项
     * @param string      $tail_content 底部内容
     * @param string|null $kf_account   指定客服帐号
     */
    public function sendMsgmenu(string $touser, string $head_content, array $list, string $tail_content, string $kf_account = null)
    {
        $extend = [
            'msgmenu' => [
                'head_content' => $head_content,
                'list'         => $list,
                'tail_content' => $tail_content
            ]
        ];
        $this->send($touser, Message::MSGTYPE_MSGMENU, $extend, $kf_account);
    }

    /**
     * 发送卡券
     * @param string      $touser     接收用户OPENID
     * @param string      $card_id    卡券ID
     * @param string|null $kf_account 指定客服帐号
     */
    public function sendWxcard(string $touser, string $card_id, string $kf_account = null)
    {
        $extend = [
            'wxcard' => [
                'card_id' => $card_id,
            ]
        ];
        $this->send($touser, Message::MSGTYPE_WXCARD, $extend, $kf_account);
    }

    /**
     * 发送小程序卡片
     * @param string      $touser         接收用户OPENID
     * @param string      $title          标题
     * @param string      $appid          小程序APPID
     * @param string      $pagepath       指定页面路径
     * @param string      $thumb_media_id 缩略图素材ID
     * @param string|null $kf_account     指定客服帐号
     */
    public function sendMiniprogrampage(string $touser, string $title, string $appid, string $pagepath, string $thumb_media_id, string $kf_account = null)
    {
        $extend = [
            'miniprogrampage' => [
                'title'          => $title,
                'appid'          => $appid,
                'pagepath'       => $pagepath,
                'thumb_media_id' => $thumb_media_id
            ]
        ];
        $this->send($touser, Message::MSGTYPE_MINIPROGRAMPAGE, $extend, $kf_account);
    }
}