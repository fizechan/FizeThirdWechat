<?php


namespace Fize\Third\Wechat\Api\Message;


use Fize\Third\Wechat\Api;


/**
 * 高级群发
 */
class Mass extends Api
{

    const MSGTYPE_TEXT = 'text';
    const MSGTYPE_IMAGE = 'image';
    const MSGTYPE_VOICE = 'voice';
    const MSGTYPE_VIDEO = 'video';
    const MSGTYPE_MUSIC = 'music';
    const MSGTYPE_NEWS = 'news';
    const MSGTYPE_MPNEWS = 'mpnews';
    const MSGTYPE_MSGMENU = 'msgmenu';
    const MSGTYPE_WXCARD = 'wxcard';
    const MSGTYPE_MINIPROGRAMPAGE = 'miniprogrampage';

    const TO_TYPE_USER = 'user';
    const TO_TYPE_WXNAME = 'wxname';

    /**
     * 根据标签进行群发
     * @param true|string|array $filter 接收者。true表示全部用户，string指定标签，array原样传入
     * @param string $msgtype 消息类型
     * @param array $extend 扩展字段
     * @param string $clientmsgid 消息识别ID
     * @return array
     */
    public function sendall($filter, $msgtype, array $extend, $clientmsgid = null)
    {
        if ($filter === true) {
            $filter = [
                'is_to_all' => $filter
            ];
        } elseif (is_string($filter)) {
            $filter = [
                'is_to_all' => false,
                'tag_id'    => $filter
            ];
        }
        $params = [
            'filter'  => $filter,
            'msgtype' => $msgtype
        ];
        if (!is_null($clientmsgid)) {
            $params['clientmsgid'] = $clientmsgid;
        }
        $params = array_merge($params, $extend);
        return $this->httpPost("/message/mass/sendall?access_token={$this->accessToken}", $params);
    }

    /**
     * 根据标签进行群发文本消息
     * @param true|string|array $filter 接收者
     * @param string $content 文本内容
     * @param string $clientmsgid 消息识别ID
     * @return array
     */
    public function sendallText($filter, $content, $clientmsgid = null)
    {
        $extend = [
            'text' => [
                'content' => $content
            ]
        ];
        return $this->sendall($filter, self::MSGTYPE_TEXT, $extend, $clientmsgid);
    }

    /**
     * 根据标签进行群发图片消息
     * @param true|string|array $filter 接收者
     * @param string $media_id 图片素材ID
     * @param string $clientmsgid 消息识别ID
     * @return array
     */
    public function sendallImage($filter, $media_id, $clientmsgid = null)
    {
        $extend = [
            'image' => [
                'media_id' => $media_id
            ]
        ];
        return $this->sendall($filter, self::MSGTYPE_IMAGE, $extend, $clientmsgid);
    }

    /**
     * 根据标签进行群发语音消息
     * @param true|string|array $filter 接收者
     * @param string $media_id 语音素材ID
     * @param string $clientmsgid 消息识别ID
     * @return array
     */
    public function sendallVoice($filter, $media_id, $clientmsgid = null)
    {
        $extend = [
            'voice' => [
                'media_id' => $media_id
            ]
        ];
        return $this->sendall($filter, self::MSGTYPE_VOICE, $extend, $clientmsgid);
    }

    /**
     * 根据标签进行群发视频消息
     * @param true|string|array $filter 接收者
     * @param string $media_id 视频素材ID
     * @param string $thumb_media_id 缩略图素材ID
     * @param string $title 标题
     * @param string $description 简介
     * @param string $clientmsgid 消息识别ID
     * @return array
     */
    public function sendallVideo($filter, $media_id, $thumb_media_id, $title, $description, $clientmsgid = null)
    {
        $extend = [
            'video' => [
                'media_id'       => $media_id,
                'thumb_media_id' => $thumb_media_id,
                'title'          => $title,
                'description'    => $description,
            ]
        ];
        return $this->sendall($filter, self::MSGTYPE_VIDEO, $extend, $clientmsgid);
    }

    /**
     * 根据标签进行群发音乐消息
     * @param true|string|array $filter 接收者
     * @param string $title 标题
     * @param string $description 简介
     * @param string $musicurl 音乐URL
     * @param string $hqmusicurl 高品质音乐URL
     * @param string $thumb_media_id 缩略图素材ID
     * @param string $clientmsgid 消息识别ID
     * @return array
     */
    public function sendallMusic($filter, $title, $description, $musicurl, $hqmusicurl, $thumb_media_id, $clientmsgid = null)
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
        return $this->sendall($filter, self::MSGTYPE_MUSIC, $extend, $clientmsgid);
    }

    /**
     * 根据标签进行群发图文消息（点击跳转到外链）
     * @param true|string|array $filter 接收者
     * @param array $articles 图文消息
     * @param string $clientmsgid 消息识别ID
     * @return array
     */
    public function sendallNews($filter, array $articles, $clientmsgid = null)
    {
        $extend = [
            'news' => [
                'articles' => $articles,
            ]
        ];
        return $this->sendall($filter, self::MSGTYPE_NEWS, $extend, $clientmsgid);
    }

    /**
     * 根据标签进行群发图文消息（点击跳转到图文消息页面）
     * @param true|string|array $filter 接收者
     * @param string $media_id 图文素材ID
     * @param int $send_ignore_reprint 图文消息被判定为转载时，是否继续群发
     * @param string $clientmsgid 消息识别ID
     * @return array
     */
    public function sendallMpnews($filter, $media_id, $send_ignore_reprint = 0, $clientmsgid = null)
    {
        $extend = [
            'mpnews'              => [
                'media_id' => $media_id,
            ],
            'send_ignore_reprint' => $send_ignore_reprint
        ];
        return $this->sendall($filter, self::MSGTYPE_MPNEWS, $extend, $clientmsgid);
    }

    /**
     * 根据标签进行群发菜单消息
     * @param true|string|array $filter 接收者
     * @param string $head_content 头部内容
     * @param array $list 选项
     * @param string $tail_content 底部内容
     * @param string $clientmsgid 消息识别ID
     * @return array
     */
    public function sendallMsgmenu($filter, $head_content, array $list, $tail_content, $clientmsgid = null)
    {
        $extend = [
            'msgmenu' => [
                'head_content' => $head_content,
                'list'         => $list,
                'tail_content' => $tail_content
            ]
        ];
        return $this->sendall($filter, self::MSGTYPE_MSGMENU, $extend, $clientmsgid);
    }

    /**
     * 根据标签进行群发卡券
     * @param true|string|array $filter 接收者
     * @param string $card_id 卡券ID
     * @param string $clientmsgid 消息识别ID
     * @return array
     */
    public function sendallWxcard($filter, $card_id, $clientmsgid = null)
    {
        $extend = [
            'wxcard' => [
                'card_id' => $card_id,
            ]
        ];
        return $this->sendall($filter, self::MSGTYPE_WXCARD, $extend, $clientmsgid);
    }

    /**
     * 根据标签进行群发小程序卡片
     * @param true|string|array $filter 接收者
     * @param string $title 标题
     * @param string $appid 小程序APPID
     * @param string $pagepath 指定页面路径
     * @param string $thumb_media_id 缩略图素材ID
     * @param string $clientmsgid 消息识别ID
     * @return array
     */
    public function sendallMiniprogrampage($filter, $title, $appid, $pagepath, $thumb_media_id, $clientmsgid = null)
    {
        $extend = [
            'miniprogrampage' => [
                'title'          => $title,
                'appid'          => $appid,
                'pagepath'       => $pagepath,
                'thumb_media_id' => $thumb_media_id
            ]
        ];
        return $this->sendall($filter, self::MSGTYPE_MINIPROGRAMPAGE, $extend, $clientmsgid);
    }

    /**
     * 根据OpenID列表群发
     * @param string|array $touser 接收者
     * @param string $msgtype 消息类型
     * @param array $extend 扩展字段
     * @param string $clientmsgid 消息识别ID
     * @return array
     */
    public function send($touser, $msgtype, array $extend, $clientmsgid = null)
    {
        if (is_string($touser)) {
            $touser = [$touser];
        }
        $params = [
            'touser'  => $touser,
            'msgtype' => $msgtype
        ];
        if (!is_null($clientmsgid)) {
            $params['clientmsgid'] = $clientmsgid;
        }
        $params = array_merge($params, $extend);
        return $this->httpPost("/message/mass/send?access_token={$this->accessToken}", $params);
    }

    /**
     * 根据OpenID列表群发文本消息
     * @param string $touser 接收者
     * @param string $content 文本内容
     * @param string $clientmsgid 消息识别ID
     * @return array
     */
    public function sendText($touser, $content, $clientmsgid = null)
    {
        $extend = [
            'text' => [
                'content' => $content
            ]
        ];
        return $this->send($touser, self::MSGTYPE_TEXT, $extend, $clientmsgid);
    }

    /**
     * 根据OpenID列表群发图片消息
     * @param string $touser 接收者
     * @param string $media_id 图片素材ID
     * @param string $clientmsgid 消息识别ID
     * @return array
     */
    public function sendImage($touser, $media_id, $clientmsgid = null)
    {
        $extend = [
            'image' => [
                'media_id' => $media_id
            ]
        ];
        return $this->send($touser, self::MSGTYPE_IMAGE, $extend, $clientmsgid);
    }

    /**
     * 根据OpenID列表群发语音消息
     * @param string $touser 接收者
     * @param string $media_id 语音素材ID
     * @param string $clientmsgid 消息识别ID
     * @return array
     */
    public function sendVoice($touser, $media_id, $clientmsgid = null)
    {
        $extend = [
            'voice' => [
                'media_id' => $media_id
            ]
        ];
        return $this->send($touser, self::MSGTYPE_VOICE, $extend, $clientmsgid);
    }

    /**
     * 根据OpenID列表群发视频消息
     * @param string $touser 接收者
     * @param string $media_id 视频素材ID
     * @param string $thumb_media_id 缩略图素材ID
     * @param string $title 标题
     * @param string $description 简介
     * @param string $clientmsgid 消息识别ID
     * @return array
     */
    public function sendVideo($touser, $media_id, $thumb_media_id, $title, $description, $clientmsgid = null)
    {
        $extend = [
            'video' => [
                'media_id'       => $media_id,
                'thumb_media_id' => $thumb_media_id,
                'title'          => $title,
                'description'    => $description,
            ]
        ];
        return $this->send($touser, self::MSGTYPE_VIDEO, $extend, $clientmsgid);
    }

    /**
     * 根据OpenID列表群发音乐消息
     * @param string $touser 接收者
     * @param string $title 标题
     * @param string $description 简介
     * @param string $musicurl 音乐URL
     * @param string $hqmusicurl 高品质音乐URL
     * @param string $thumb_media_id 缩略图素材ID
     * @param string $clientmsgid 消息识别ID
     * @return array
     */
    public function sendMusic($touser, $title, $description, $musicurl, $hqmusicurl, $thumb_media_id, $clientmsgid = null)
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
        return $this->send($touser, self::MSGTYPE_MUSIC, $extend, $clientmsgid);
    }

    /**
     * 根据OpenID列表群发图文消息（点击跳转到外链）
     * @param string $touser 接收者
     * @param array $articles 图文消息
     * @param string $clientmsgid 消息识别ID
     * @return array
     */
    public function sendNews($touser, array $articles, $clientmsgid = null)
    {
        $extend = [
            'news' => [
                'articles' => $articles,
            ]
        ];
        return $this->send($touser, self::MSGTYPE_NEWS, $extend, $clientmsgid);
    }

    /**
     * 根据OpenID列表群发图文消息（点击跳转到图文消息页面）
     * @param string $touser 接收者
     * @param string $media_id 图文素材ID
     * @param string $clientmsgid 消息识别ID
     * @return array
     */
    public function sendMpnews($touser, $media_id, $clientmsgid = null)
    {
        $extend = [
            'mpnews' => [
                'media_id' => $media_id,
            ]
        ];
        return $this->send($touser, self::MSGTYPE_MPNEWS, $extend, $clientmsgid);
    }

    /**
     * 根据OpenID列表群发菜单消息
     * @param string $touser 接收者
     * @param string $head_content 头部内容
     * @param array $list 选项
     * @param string $tail_content 底部内容
     * @param string $clientmsgid 消息识别ID
     * @return array
     */
    public function sendMsgmenu($touser, $head_content, array $list, $tail_content, $clientmsgid = null)
    {
        $extend = [
            'msgmenu' => [
                'head_content' => $head_content,
                'list'         => $list,
                'tail_content' => $tail_content
            ]
        ];
        return $this->send($touser, self::MSGTYPE_MSGMENU, $extend, $clientmsgid);
    }

    /**
     * 根据OpenID列表群发卡券
     * @param string $touser 接收者
     * @param string $card_id 卡券ID
     * @param string $clientmsgid 消息识别ID
     * @return array
     */
    public function sendWxcard($touser, $card_id, $clientmsgid = null)
    {
        $extend = [
            'wxcard' => [
                'card_id' => $card_id,
            ]
        ];
        return $this->send($touser, self::MSGTYPE_WXCARD, $extend, $clientmsgid);
    }

    /**
     * 根据OpenID列表群发小程序卡片
     * @param string $touser 接收者
     * @param string $title 标题
     * @param string $appid 小程序APPID
     * @param string $pagepath 指定页面路径
     * @param string $thumb_media_id 缩略图素材ID
     * @param string $clientmsgid 消息识别ID
     * @return array
     */
    public function sendMiniprogrampage($touser, $title, $appid, $pagepath, $thumb_media_id, $clientmsgid = null)
    {
        $extend = [
            'miniprogrampage' => [
                'title'          => $title,
                'appid'          => $appid,
                'pagepath'       => $pagepath,
                'thumb_media_id' => $thumb_media_id
            ]
        ];
        return $this->send($touser, self::MSGTYPE_MINIPROGRAMPAGE, $extend, $clientmsgid);
    }

    /**
     * 删除群发
     * @param string $msg_id 发送出去的消息ID
     * @param int $article_idx 要删除的文章在图文消息中的位置，第一篇编号为1，该字段不填或填0会删除全部文章
     */
    public function delete($msg_id, $article_idx = null)
    {
        $params = [
            'msg_id' => $msg_id
        ];
        if (!is_null($article_idx)) {
            $params['article_idx'] = $article_idx;
        }
        $this->httpPost("/message/mass/delete?access_token={$this->accessToken}", $params);
    }

    /**
     * 预览群发
     * @param string $to 接收者
     * @param string $msgtype 消息类型
     * @param array $extend 扩展字段
     * @param string $to_type 接收者类型
     * @return array
     */
    public function preview($to, $msgtype, array $extend, $to_type = 'user')
    {
        $params = [
            "to{$to_type}" => $to,
            'msgtype'      => $msgtype
        ];
        $params = array_merge($params, $extend);
        return $this->httpPost("/message/mass/preview?access_token={$this->accessToken}", $params);
    }

    /**
     * 预览群发文本消息
     * @param string $to 接收者
     * @param string $content 文本内容
     * @param string $to_type 接收者类型
     * @return array
     */
    public function previewText($to, $content, $to_type = 'user')
    {
        $extend = [
            'text' => [
                'content' => $content
            ]
        ];
        return $this->preview($to, self::MSGTYPE_TEXT, $extend, $to_type);
    }

    /**
     * 预览群发图片消息
     * @param string $to 接收者
     * @param string $media_id 图片素材ID
     * @param string $to_type 接收者类型
     * @return array
     */
    public function previewImage($to, $media_id, $to_type = 'user')
    {
        $extend = [
            'image' => [
                'media_id' => $media_id
            ]
        ];
        return $this->preview($to, self::MSGTYPE_IMAGE, $extend, $to_type);
    }

    /**
     * 预览群发语音消息
     * @param string $to 接收者
     * @param string $media_id 语音素材ID
     * @param string $to_type 接收者类型
     * @return array
     */
    public function previewVoice($to, $media_id, $to_type = 'user')
    {
        $extend = [
            'voice' => [
                'media_id' => $media_id
            ]
        ];
        return $this->preview($to, self::MSGTYPE_VOICE, $extend, $to_type);
    }

    /**
     * 预览群发视频消息
     * @param string $to 接收者
     * @param string $media_id 视频素材ID
     * @param string $thumb_media_id 缩略图素材ID
     * @param string $title 标题
     * @param string $description 简介
     * @param string $to_type 接收者类型
     * @return array
     */
    public function previewVideo($to, $media_id, $thumb_media_id, $title, $description, $to_type = 'user')
    {
        $extend = [
            'video' => [
                'media_id'       => $media_id,
                'thumb_media_id' => $thumb_media_id,
                'title'          => $title,
                'description'    => $description,
            ]
        ];
        return $this->preview($to, self::MSGTYPE_VIDEO, $extend, $to_type);
    }

    /**
     * 预览群发音乐消息
     * @param string $to 接收者
     * @param string $title 标题
     * @param string $description 简介
     * @param string $musicurl 音乐URL
     * @param string $hqmusicurl 高品质音乐URL
     * @param string $thumb_media_id 缩略图素材ID
     * @param string $to_type 接收者类型
     * @return array
     */
    public function previewMusic($to, $title, $description, $musicurl, $hqmusicurl, $thumb_media_id, $to_type = 'user')
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
        return $this->preview($to, self::MSGTYPE_MUSIC, $extend, $to_type);
    }

    /**
     * 预览群发图文消息（点击跳转到外链）
     * @param string $to 接收者
     * @param array $articles 图文消息
     * @param string $to_type 接收者类型
     * @return array
     */
    public function previewNews($to, array $articles, $to_type = 'user')
    {
        $extend = [
            'news' => [
                'articles' => $articles,
            ]
        ];
        return $this->preview($to, self::MSGTYPE_NEWS, $extend, $to_type);
    }

    /**
     * 预览群发图文消息（点击跳转到图文消息页面）
     * @param string $to 接收者
     * @param string $media_id 图文素材ID
     * @param string $to_type 接收者类型
     * @return array
     */
    public function previewMpnews($to, $media_id, $to_type = 'user')
    {
        $extend = [
            'mpnews' => [
                'media_id' => $media_id,
            ]
        ];
        return $this->preview($to, self::MSGTYPE_MPNEWS, $extend, $to_type);
    }

    /**
     * 预览群发菜单消息
     * @param string $to 接收者
     * @param string $head_content 头部内容
     * @param array $list 选项
     * @param string $tail_content 底部内容
     * @param string $to_type 接收者类型
     * @return array
     */
    public function previewMsgmenu($to, $head_content, array $list, $tail_content, $to_type = 'user')
    {
        $extend = [
            'msgmenu' => [
                'head_content' => $head_content,
                'list'         => $list,
                'tail_content' => $tail_content
            ]
        ];
        return $this->preview($to, self::MSGTYPE_MSGMENU, $extend, $to_type);
    }

    /**
     * 预览群发卡券
     * @param string $to 接收者
     * @param string $card_id 卡券ID
     * @param string $to_type 接收者类型
     * @return array
     */
    public function previewWxcard($to, $card_id, $to_type = 'user')
    {
        $extend = [
            'wxcard' => [
                'card_id' => $card_id,
            ]
        ];
        return $this->preview($to, self::MSGTYPE_WXCARD, $extend, $to_type);
    }

    /**
     * 预览群发小程序卡片
     * @param string $to 接收者
     * @param string $title 标题
     * @param string $appid 小程序APPID
     * @param string $pagepath 指定页面路径
     * @param string $thumb_media_id 缩略图素材ID
     * @param string $to_type 接收者类型
     * @return array
     */
    public function previewMiniprogrampage($to, $title, $appid, $pagepath, $thumb_media_id, $to_type = 'user')
    {
        $extend = [
            'miniprogrampage' => [
                'title'          => $title,
                'appid'          => $appid,
                'pagepath'       => $pagepath,
                'thumb_media_id' => $thumb_media_id
            ]
        ];
        return $this->preview($to, self::MSGTYPE_MINIPROGRAMPAGE, $extend, $to_type);
    }

    /**
     * 查询群发消息发送状态
     * @param string $msg_id 群发消息后返回的消息id
     * @return array
     */
    public function get($msg_id)
    {
        $params = [
            'msg_id' => $msg_id
        ];
        return $this->httpPost("/message/mass/get?access_token={$this->accessToken}", $params);
    }
}
