<?php

namespace Fize\Third\Wechat;

use Fize\Crypt\XML;
use OutOfBoundsException;

/**
 * 微信信息发送类
 *
 * 本接口非微信直接提供
 */
class MessageReply extends Message
{

    /**
     * @var string 开发者微信号
     */
    private $fromUserName;

    /**
     * @var string 接收方帐号
     */
    private $toUserName;

    /**
     * @var array 消息体
     */
    private $message;

    /**
     * @var bool 是否过滤文字回复\r\n换行符
     */
    private $textFilter = true;

    /**
     * 设置开发者微信号
     * @param string $fromUserName 开发者微信号
     * @return $this
     */
    public function setFromUserName(string $fromUserName): MessageReply
    {
        $this->fromUserName = $fromUserName;
        return $this;
    }

    /**
     * 设置接收方帐号（收到的OpenID）
     * @param string $toUserName 接收方帐号
     * @return $this
     */
    public function setToUserName(string $toUserName): MessageReply
    {
        $this->toUserName = $toUserName;
        return $this;
    }

    /**
     * 设置发送消息
     * @param array $message 消息数组
     * @param bool  $append  是否在原消息数组追加
     * @return array 返回当前消息体
     */
    public function message(array $message, bool $append = false): array
    {
        if ($append) {
            $this->message = array_merge($this->message, $message);
        } else {
            $this->message = $message;
        }
        return $this->message;
    }

    /**
     * 设置文本回复消息
     * @param string $content 文本内容
     * @return $this
     */
    public function text(string $content): MessageReply
    {
        $msg = [
            'ToUserName'   => $this->toUserName,
            'FromUserName' => $this->fromUserName,
            'CreateTime'   => time(),
            'MsgType'      => self::MSGTYPE_TEXT,
            'Content'      => $this->autoTextFilter($content)
        ];
        $this->message($msg);
        return $this;
    }

    /**
     * 设置图片回复消息
     * @param string $mediaId 多媒体ID
     * @return $this
     */
    public function image(string $mediaId): MessageReply
    {
        $msg = [
            'ToUserName'   => $this->toUserName,
            'FromUserName' => $this->fromUserName,
            'CreateTime'   => time(),
            'MsgType'      => self::MSGTYPE_IMAGE,
            'Image'        => ['MediaId' => $mediaId]
        ];
        $this->message($msg);
        return $this;
    }

    /**
     * 设置语音回复消息
     * @param string $mediaId 多媒体ID
     * @return $this
     */
    public function voice(string $mediaId): MessageReply
    {
        $msg = [
            'ToUserName'   => $this->toUserName,
            'FromUserName' => $this->fromUserName,
            'CreateTime'   => time(),
            'MsgType'      => self::MSGTYPE_VOICE,
            'Voice'        => ['MediaId' => $mediaId]
        ];
        $this->message($msg);
        return $this;
    }

    /**
     * 设置视频回复消息
     * @param string      $mediaId     多媒体ID
     * @param string|null $title       视频消息的标题
     * @param string|null $description 视频消息的描述
     * @return $this
     */
    public function video(string $mediaId, string $title = null, string $description = null): MessageReply
    {
        $msg = [
            'ToUserName'   => $this->toUserName,
            'FromUserName' => $this->fromUserName,
            'CreateTime'   => time(),
            'MsgType'      => self::MSGTYPE_VIDEO,
            'Video'        => [
                'MediaId' => $mediaId
            ]
        ];
        if (!is_null($title)) {
            $msg['Video']['Title'] = $title;
        }
        if (!is_null($description)) {
            $msg['Video']['Description'] = $description;
        }
        $this->message($msg);
        return $this;
    }

    /**
     * 设置回复音乐
     * @param string      $thumbMediaId 缩略图的媒体id
     * @param string|null $title        音乐标题
     * @param string|null $desc         音乐描述
     * @param string|null $musicUrl     音乐链接
     * @param string|null $hqMusicUrl   高质量音乐链接
     * @return $this
     */
    public function music(string $thumbMediaId, string $title = null, string $desc = null, string $musicUrl = null, string $hqMusicUrl = null): MessageReply
    {
        $msg = [
            'ToUserName'   => $this->toUserName,
            'FromUserName' => $this->fromUserName,
            'CreateTime'   => time(),
            'MsgType'      => self::MSGTYPE_MUSIC,
            'Music'        => [
                'ThumbMediaId' => $thumbMediaId
            ]
        ];
        if (!is_null($title)) {
            $msg['Music']['Title'] = $title;
        }
        if (!is_null($desc)) {
            $msg['Music']['Description'] = $desc;
        }
        if (!is_null($musicUrl)) {
            $msg['Music']['MusicUrl'] = $musicUrl;
        }
        if (!is_null($hqMusicUrl)) {
            $msg['Music']['HQMusicUrl'] = $hqMusicUrl;
        }
        $this->Message($msg);
        return $this;
    }

    /**
     * 设置回复图文消息
     * @param array $articles 图文数组，每项为['Title' => *, 'Description' => *, 'PicUrl' => *, 'Url' => *]
     * @return $this
     */
    public function news(array $articles): MessageReply
    {
        $msg = [
            'ToUserName'   => $this->toUserName,
            'FromUserName' => $this->fromUserName,
            'CreateTime'   => time(),
            'MsgType'      => self::MSGTYPE_NEWS,
            'ArticleCount' => count($articles),
            'Articles'     => $articles
        ];
        $this->message($msg);
        return $this;
    }

    /**
     * 消息转发到多客服
     * Example: $obj->transferCustomerService($customer_account);
     * @param string|null $kfAccount 转发到指定客服帐号
     * @return $this
     */
    public function transferCustomerService(string $kfAccount = null): MessageReply
    {
        $msg = [
            'ToUserName'   => $this->toUserName,
            'FromUserName' => $this->fromUserName,
            'CreateTime'   => time(),
            'MsgType'      => self::MSGTYPE_TRANSFER_CUSTOMER_SERVICE,
        ];
        if (!empty($kfAccount)) {
            $msg['TransInfo'] = ['KfAccount' => $kfAccount];
        }
        $this->message($msg);
        return $this;
    }

    /**
     *
     * 返回XML响应
     * @return string
     */
    public function xml()
    {
        if (empty($this->toUserName)) {
            throw new OutOfBoundsException("XML消息体标签ToUserName必须设置");
        }
        if (empty($this->fromUserName)) {
            throw new OutOfBoundsException("XML消息体标签FromUserName必须设置");
        }
        if (empty($this->message)) {
            throw new OutOfBoundsException("XML消息体尚未设置");
        }
        $xmldata = Xml::encode($this->message);
        if ($this->encrypt_type == 'aes') {  // 如果来源消息为加密方式
            $pc = new Prpcrypt($this->encodingAesKey);
            $array = $pc->encrypt($xmldata, $this->appId);
            $ret = $array[0];
            if ($ret != 0) {
                return false;
            }
            $timestamp = time();
            $nonce = rand(77, 999) * rand(605, 888) * rand(11, 99);
            $encrypt = $array[1];
            $tmpArr = [$this->token, $timestamp, $nonce, $encrypt];//比普通公众平台多了一个加密的密文
            sort($tmpArr, SORT_STRING);
            $signature = implode($tmpArr);
            $signature = sha1($signature);
            $xmldata = $this->generate($encrypt, $signature, $timestamp, $nonce);
        }
        return $xmldata;
    }

    /**
     * 发送，即输出XML
     */
    public function send()
    {
        echo $this->xml();
    }

    /**
     * 过滤文字回复\r\n换行符
     * @param string $text
     * @return string
     */
    private function autoTextFilter(string $text): string
    {
        if (!$this->textFilter) {
            return $text;
        }
        return str_replace("\r\n", "\n", $text);
    }

    /**
     * xml格式加密，仅请求为加密方式时再用
     * @param $encrypt
     * @param $signature
     * @param $timestamp
     * @param $nonce
     * @return string
     */
    private function generate($encrypt, $signature, $timestamp, $nonce): string
    {
        // 格式化加密信息
        $format = <<<XML
<xml>
<Encrypt><![CDATA[%s]]></Encrypt>
<MsgSignature><![CDATA[%s]]></MsgSignature>
<TimeStamp>%s</TimeStamp>
<Nonce><![CDATA[%s]]></Nonce>
</xml>
XML;
        return sprintf($format, $encrypt, $signature, $timestamp, $nonce);
    }
}
