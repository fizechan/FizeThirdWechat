<?php


namespace fize\third\wechat\api;


use fize\third\wechat\Api;
use fize\crypt\Json;


/**
 * 微信高级群发类
 */
class Mass extends Api
{

    const URL_MASS_SEND_GROUP = '/message/mass/sendall?';

    const URL_MASS_SEND = '/message/mass/send?';

    const URL_MASS_DELETE = '/message/mass/delete?';
    const URL_MASS_PREVIEW = '/message/mass/preview?';
    const URL_MASS_QUERY = '/message/mass/get?';

    /**
     * 构造函数
     * @param array $options 参数数组
     */
    public function __construct($options)
    {
        parent::__construct($options);
        //检测TOKEN
        $this->checkAccessToken();
    }

    /**
     * 高级群发消息, 根据群组id群发图文消息(认证后的订阅号可用)
     *    注意：视频需要在调用uploadMedia()方法后，再使用 uploadMpVideo() 方法生成，
     *             然后获得的 mediaid 才能用于群发，且消息类型为 mpvideo 类型。
     * @param array $data 消息结构
     * {
     *     "filter"=>array(
     *         "is_to_all"=>False,     //是否群发给所有用户.True不用分组id，False需填写分组id
     *         "group_id"=>"2"     //群发的分组id
     *     ),
     *      "msgtype"=>"mpvideo",
     *      // 在下面5种类型中选择对应的参数内容
     *      // mpnews | voice | image | mpvideo => array( "media_id"=>"MediaId")
     *      // text => array ( "content" => "hello")
     * }
     * @return mixed
     */
    public function sendGroupMassMessage($data)
    {
        $json = $this->httpPost(self::PREFIX_CGI . self::URL_MASS_SEND_GROUP . 'access_token=' . $this->accessToken, Json::encode($data, JSON_UNESCAPED_UNICODE));
        if ($json) {
            return $json;
        } else {
            return false;
        }
    }

    /**
     * 高级群发消息, 根据OpenID列表群发图文消息(订阅号不可用)
     *    注意：视频需要在调用uploadMedia()方法后，再使用 uploadMpVideo() 方法生成，
     *             然后获得的 mediaid 才能用于群发，且消息类型为 mpvideo 类型。
     * @param array $data 消息结构
     * {
     *     "touser"=>array(
     *         "OPENID1",
     *         "OPENID2"
     *     ),
     *      "msgtype"=>"mpvideo",
     *      // 在下面5种类型中选择对应的参数内容
     *      // mpnews | voice | image | mpvideo => array( "media_id"=>"MediaId")
     *      // text => array ( "content" => "hello")
     * }
     * @return mixed
     */
    public function sendMassMessage($data)
    {
        $json = $this->httpPost(self::PREFIX_CGI . self::URL_MASS_SEND . 'access_token=' . $this->accessToken, Json::encode($data, JSON_UNESCAPED_UNICODE));
        if ($json) {
            return $json;
        } else {
            return false;
        }
    }

    /**
     * 高级群发消息, 删除群发图文消息(认证后的订阅号可用)
     * @param int $msg_id 消息id
     * @return boolean
     */
    public function deleteMassMessage($msg_id)
    {
        $json = $this->httpPost(self::PREFIX_CGI . self::URL_MASS_DELETE . 'access_token=' . $this->accessToken, Json::encode(['msg_id' => $msg_id]));
        if ($json) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 高级群发消息, 预览群发消息(认证后的订阅号可用)
     *    注意：视频需要在调用uploadMedia()方法后，再使用 uploadMpVideo() 方法生成，
     *             然后获得的 mediaid 才能用于群发，且消息类型为 mpvideo 类型。
     * @param array $data 消息结构
     * {
     *     "touser"=>"OPENID",
     *      "msgtype"=>"mpvideo",
     *      // 在下面5种类型中选择对应的参数内容
     *      // mpnews | voice | image | mpvideo => array( "media_id"=>"MediaId")
     *      // text => array ( "content" => "hello")
     * }
     * @return boolean|array
     */
    public function previewMassMessage($data)
    {
        $json = $this->httpPost(self::PREFIX_CGI . self::URL_MASS_PREVIEW . 'access_token=' . $this->accessToken, Json::encode($data, JSON_UNESCAPED_UNICODE));
        if ($json) {
            return $json;
        } else {
            return false;
        }
    }

    /**
     * 高级群发消息, 查询群发消息发送状态(认证后的订阅号可用)
     * @param int $msg_id 消息id
     * @return mixed
     * {
     *     "msg_id":201053012,     //群发消息后返回的消息id
     *     "msg_status":"SEND_SUCCESS" //消息发送后的状态，SENDING表示正在发送 SEND_SUCCESS表示发送成功
     * }
     */
    public function queryMassMessage($msg_id)
    {
        $json = $this->httpPost(self::PREFIX_CGI . self::URL_MASS_QUERY . 'access_token=' . $this->accessToken, Json::encode(['msg_id' => $msg_id]));
        if ($json) {
            return $json;
        } else {
            return false;
        }
    }
}
