<?php


namespace fize\third\wechat;


use fize\third\wechat\Prpcrypt;
use fize\crypt\Xml;


/**
 * 微信信息发送类
 *
 * 本接口非微信直接提供
 */
class MessageReply extends Message
{

    const MSGTYPE_TEXT = 'text';
    const MSGTYPE_IMAGE = 'image';
    const MSGTYPE_LOCATION = 'location';
    const MSGTYPE_LINK = 'link';
    const MSGTYPE_EVENT = 'event';
    const MSGTYPE_MUSIC = 'music';
    const MSGTYPE_NEWS = 'news';
    const MSGTYPE_VOICE = 'voice';
    const MSGTYPE_VIDEO = 'video';
    const MSGTYPE_TRANSFER = 'transfer_customer_service';

    private $_msg;

    private $_to;

    private $_from;

    private $_text_filter = true;

    /**
     * 构造函数
     * @param array $options 参数数组
     */
    public function __construct($options)
    {
        parent::__construct($options);
        $this->_from = $options['fromusername'];
    }

    /**
     * 设置发送消息
     * @param array $msg 消息数组
     * @param bool $append 是否在原消息数组追加
     * @return mixed
     */
    public function Message($msg = array(), $append = false)
    {
        if (is_null($msg)) {
            $this->_msg = array();
        } elseif (is_array($msg)) {
            if ($append) {
                $this->_msg = array_merge($this->_msg, $msg);
            } else {
                $this->_msg = $msg;
            }
        } else {
            if ($append) {
                $this->_msg = array_merge($this->_msg, $msg);
            } else {
                $this->_msg = $msg;
            }
        }
        return $this->_msg;
    }

    /**
     * 设置接收方和发送方,需要在链式优先调用
     * @param string $p_to
     * @return $this
     */
    public function to($p_to)
    {
        $this->_to = $p_to;
        return $this;
    }

    /**
     * 过滤文字回复\r\n换行符
     * @param string $text
     * @return mixed
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
     */
    public function text($text)
    {
        $msg = array(
            'ToUserName' => $this->_to,
            'FromUserName' => $this->_from,
            'CreateTime' => time(),
            'MsgType' => self::MSGTYPE_TEXT,
            'Content' => $this->_auto_text_filter($text)
        );
        $this->Message($msg);
        return $this;
    }

    /**
     * 设置图片回复消息
     * Example: $obj->image('media_id')->reply();
     * @param string $mediaid
     */
    public function image($mediaid)
    {
        $msg = array(
            'ToUserName' => $this->_to,
            'FromUserName' => $this->_from,
            'CreateTime' => time(),
            'MsgType' => self::MSGTYPE_IMAGE,
            'Image' => array('MediaId' => $mediaid)
        );
        $this->Message($msg);
        return $this;
    }

    /**
     * 设置语音回复消息
     * Example: $obj->voice('media_id')->reply();
     * @param string $mediaid
     */
    public function voice($mediaid)
    {
        $msg = array(
            'ToUserName' => $this->_to,
            'FromUserName' => $this->_from,
            'CreateTime' => time(),
            'MsgType' => self::MSGTYPE_VOICE,
            'Voice' => array('MediaId' => $mediaid)
        );
        $this->Message($msg);
        return $this;
    }

    /**
     * 设置视频回复消息
     * Example: $obj->video('media_id','title','description')->reply();
     * @param string $mediaid
     */
    public function video($mediaid, $title = '', $description = '')
    {
        $msg = array(
            'ToUserName' => $this->_to,
            'FromUserName' => $this->_from,
            'CreateTime' => time(),
            'MsgType' => self::MSGTYPE_VIDEO,
            'Video' => array(
                'MediaId' => $mediaid,
                'Title' => $title,
                'Description' => $description
            )
        );
        $this->Message($msg);
        return $this;
    }

    /**
     * 设置回复音乐
     * @param string $title
     * @param string $desc
     * @param string $musicurl
     * @param string $hqmusicurl
     * @param string $thumbmediaid 音乐图片缩略图的媒体id
     */
    public function music($title, $desc, $musicurl, $hqmusicurl, $thumbmediaid)
    {
        $msg = array(
            'ToUserName' => $this->_to,
            'FromUserName' => $this->_from,
            'CreateTime' => time(),
            'MsgType' => self::MSGTYPE_MUSIC,
            'Music' => array(
                'Title' => $title,
                'Description' => $desc,
                'MusicUrl' => $musicurl,
                'HQMusicUrl' => $hqmusicurl,
                'ThumbMediaId' => $thumbmediaid
            )
        );
        $this->Message($msg);
        return $this;
    }

    /**
     * 设置回复图文
     * @param array $newsData
     * @return mixed
     * 数组结构:
     *  array(
     *    "0"=>array(
     *        'Title'=>'msg title',
     *        'Description'=>'summary text',
     *        'PicUrl'=>'http://www.domain.com/1.jpg',
     *        'Url'=>'http://www.domain.com/1.html'
     *    ),
     *    "1"=>....
     *  )
     */
    public function news($newsData)
    {
        $count = count($newsData);
        $msg = array(
            'ToUserName' => $this->_to,
            'FromUserName' => $this->_from,
            'CreateTime' => time(),
            'MsgType' => self::MSGTYPE_NEWS,
            'ArticleCount' => $count,
            'Articles' => $newsData
        );
        $this->Message($msg);
        return $this;
    }

    /**
     * xml格式加密，仅请求为加密方式时再用
     */
    private function generate($encrypt, $signature, $timestamp, $nonce)
    {
        //格式化加密信息
        $format = <<<EOF
<xml>
<Encrypt><![CDATA[%s]]></Encrypt>
<MsgSignature><![CDATA[%s]]></MsgSignature>
<TimeStamp>%s</TimeStamp>
<Nonce><![CDATA[%s]]></Nonce>
</xml>
EOF;
        return sprintf($format, $encrypt, $signature, $timestamp, $nonce);
    }

    /**
     *
     * 回复微信服务器, 此函数支持链式操作
     * Example: $this->text('msg tips')->reply();
     * @param string $msg 要发送的信息, 默认取$this->_msg
     * @param bool $return 是否返回信息而不抛出到浏览器 默认:否
     * @return mixed
     */
    public function send($msg = array(), $return = false)
    {
        if (empty($this->_to)) {
            return false;
        }
        if (empty($this->_from)) {
            return false;
        }
        if (empty($msg)) {
            if (empty($this->_msg)) {
                //防止不先设置回复内容，直接调用reply方法导致异常
                return false;
            }
            $msg = $this->_msg;
        }
        $xmldata = Xml::encode($msg);
        //Log::write($xmldata);
        if ($this->encrypt_type == 'aes') { //如果来源消息为加密方式
            $pc = new Prpcrypt($this->encodingAesKey);
            $array = $pc->encrypt($xmldata, $this->appid);
            $ret = $array[0];
            if ($ret != 0) {
                //Log::write('encrypt err!');
                return false;
            }
            $timestamp = time();
            $nonce = rand(77, 999) * rand(605, 888) * rand(11, 99);
            $encrypt = $array[1];
            $tmpArr = array($this->token, $timestamp, $nonce, $encrypt);//比普通公众平台多了一个加密的密文
            sort($tmpArr, SORT_STRING);
            $signature = implode($tmpArr);
            $signature = sha1($signature);
            $xmldata = $this->generate($encrypt, $signature, $timestamp, $nonce);
            //Log::write($xmldata);
        }
        if ($return) {
            return $xmldata;
        } else {
            echo $xmldata;
            return null;
        }
    }

    /**
     * 消息转发到多客服
     * Example: $obj->transferCustomerService($customer_account);
     * @param string $customer_account 转发到指定客服帐号：test1@test
     */
    public function transferCustomerService($customer_account = '')
    {
        $msg = [
            'ToUserName' => $this->_to,
            'FromUserName' => $this->_from,
            'CreateTime' => time(),
            'MsgType' => self::MSGTYPE_TRANSFER,
        ];
        if (!empty($customer_account)) {
            $msg['TransInfo'] = ['KfAccount' => $customer_account];
        }
        $this->send($msg);
    }
}
