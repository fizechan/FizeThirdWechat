<?php


namespace fize\third\wechat\api;


use fize\third\wechat\Api;
use fize\crypt\Json;


/**
 * 微信客服信息回复类
 */
class KfReply extends Api
{

    const URL_CUSTOM_SEND = '/message/custom/send?';

    const MSGTYPE_TEXT = 'text';
    const MSGTYPE_IMAGE = 'image';
    const MSGTYPE_VOICE = 'voice';
    const MSGTYPE_VIDEO = 'video';
    const MSGTYPE_MUSIC = 'music';
    const MSGTYPE_NEWS = 'news';

    private $_data;

    private $_to = '';

    private $_from = '';

    private $_text_filter = true;

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
     * 发送客服消息
     * @param array $data 消息结构{"touser":"OPENID","msgtype":"news","news":{...}}
     * @return boolean|array
     */
    private function send_custom_message($data)
    {
        $json = $this->httpPost(self::PREFIX_CGI . self::URL_CUSTOM_SEND . 'access_token=' . $this->access_token, Json::encode($data, JSON_UNESCAPED_UNICODE));
        if ($json) {
            return $json;
        } else {
            return false;
        }
    }

    /**
     * 设置接收方和发送客服,需要在链式优先调用
     * @param string $p_to
     * @param string $p_from
     * @return $this
     */
    public function set($p_to, $p_from = '')
    {
        $this->_to = $p_to;
        $this->_from = $p_from;
        return $this;
    }

    /**
     * 过滤文字回复\r\n换行符
     * @param string $text
     * @return string|mixed
     */
    private function _auto_text_filter($text)
    {
        if (!$this->_text_filter) return $text;
        return str_replace("\r\n", "\n", $text);
    }

    /**
     * 设置文本回复消息
     * Example: $obj->text('hello')->reply();
     * @param string $text
     * @return $this
     */
    public function text($text)
    {
        $this->_data = array(
            'touser' => $this->_to,
            'msgtype' => self::MSGTYPE_TEXT,
            'text' => array(
                'content' => $this->_auto_text_filter($text)
            )
        );
        return $this;
    }

    /**
     * 设置图片回复消息
     * Example: $obj->image('media_id')->reply();
     * @param string $mediaid
     * @return $this
     */
    public function image($mediaid)
    {
        $this->_data = array(
            'touser' => $this->_to,
            'msgtype' => self::MSGTYPE_IMAGE,
            'image' => array(
                'media_id' => $mediaid
            )
        );
        return $this;
    }

    /**
     * 设置语音回复消息
     * Example: $obj->voice('media_id')->reply();
     * @param string $mediaid
     * @return $this
     */
    public function voice($mediaid)
    {
        $this->_data = array(
            'touser' => $this->_to,
            'msgtype' => self::MSGTYPE_VOICE,
            'voice' => array(
                'media_id' => $mediaid
            )
        );
        return $this;
    }

    /**
     * 设置视频回复消息
     * @param string $mediaid
     * @param string $thumbid
     * @param string $title
     * @param string $description
     * @return $this
     */
    public function video($mediaid, $thumbid, $title = '', $description = '')
    {
        $this->_data = array(
            'touser' => $this->_to,
            'msgtype' => self::MSGTYPE_VIDEO,
            'video' => array(
                'media_id' => $mediaid,
                'thumb_media_id' => $thumbid,
                'title' => $title,
                'description' => $description
            )
        );
        return $this;
    }

    /**
     * 设置回复音乐
     * @param string $title
     * @param string $desc
     * @param string $musicurl
     * @param string $hqmusicurl
     * @param string $thumbmediaid 音乐图片缩略图的媒体id
     * @return $this
     */
    public function music($title, $desc, $musicurl, $hqmusicurl, $thumbmediaid)
    {
        $this->_data = array(
            'touser' => $this->_to,
            'msgtype' => self::MSGTYPE_MUSIC,
            'music' => array(
                'title' => $title,
                'description' => $desc,
                'musicurl' => $musicurl,
                'hqmusicurl' => $hqmusicurl,
                'thumb_media_id' => $thumbmediaid
            )
        );
        return $this;
    }

    /**
     * 设置回复图文
     * @param array $newsData
     * @return $this
     */
    public function news($newsData)
    {
        $this->_data = array(
            'touser' => $this->_to,
            'msgtype' => self::MSGTYPE_NEWS,
            'news' => array(
                'articles' => $newsData
            )
        );
        return $this;
    }

    /**
     *
     * 回复微信服务器, 此函数支持链式操作
     * Example: $this->text('msg tips')->reply();
     * @param array $data 要发送的信息, 默认取$this->_data
     * @return mixed
     */
    public function reply(array $data = [])
    {
        if (empty($this->_to)) {
            return false;
        }
        if (empty($data)) {
            if (empty($this->_data)) {
                //防止不先设置回复内容，直接调用reply方法导致异常
                return false;
            }
            $data = $this->_data;
        }
        if (!empty($this->_from)) {
            //加入指定客服
            $data = array_merge($data, array('customservice' => array('kf_account' => $this->_from)));
        }
        return $this->send_custom_message($data);
    }
}