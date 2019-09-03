<?php


namespace fize\third\wechat\api;


use fize\third\wechat\Api;
use fize\crypt\Json;


/**
 * 微信客服会话管理类
 */
class KfSession extends Api
{

    const URL_CUSTOM_SEESSION_CREATE = '/customservice/kfsession/create?';
    const URL_CUSTOM_SEESSION_CLOSE = '/customservice/kfsession/close?';
    const URL_CUSTOM_SEESSION_GET = '/customservice/kfsession/getsession?';
    const URL_CUSTOM_SEESSION_GET_LIST = '/customservice/kfsession/getsessionlist?';
    const URL_CUSTOM_SEESSION_GET_WAIT = '/customservice/kfsession/getwaitcase?';

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
     * 创建会话
     * @tutorial 当用户已被其他客服接待或指定客服不在线则会失败
     * @param string $openid //用户openid
     * @param string $kf_account //客服账号
     * @param string $text //附加信息，文本会展示在客服人员的多客服客户端，可为空
     * @return boolean
     */
    public function createKfSession($openid, $kf_account, $text = '')
    {
        $data = array(
            "openid"     => $openid,
            "kf_account" => $kf_account
        );
        if ($text) {
            $data["text"] = $text;
        }
        $result = $this->httpPost(self::PREFIX_API . self::URL_CUSTOM_SEESSION_CREATE . 'access_token=' . $this->access_token, Json::encode($data, JSON_UNESCAPED_UNICODE));
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 关闭会话
     * @tutorial 当用户被其他客服接待时则会失败
     * @param string $openid //用户openid
     * @param string $kf_account //客服账号
     * @param string $text //附加信息，文本会展示在客服人员的多客服客户端，可为空
     * @return boolean | array            //成功返回json数组
     * {
     *   "errcode": 0,
     *   "errmsg": "ok",
     * }
     */
    public function closeKfSession($openid, $kf_account, $text = '')
    {
        $data = array(
            "openid"     => $openid,
            "kf_account" => $kf_account
        );
        if ($text) {
            $data["text"] = $text;
        }
        $result = $this->httpPost(self::PREFIX_API . self::URL_CUSTOM_SEESSION_CLOSE . 'access_token=' . $this->access_token, Json::encode($data, JSON_UNESCAPED_UNICODE));
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 获取客户的会话状态
     * @param string $openid //用户openid
     * @return boolean | array            //成功返回json数组
     * {
     *     "errcode" : 0,
     *     "errmsg" : "ok",
     *     "kf_account" : "test1@test",    //正在接待的客服
     *     "createtime": 123456789,        //会话接入时间
     *  }
     */
    public function getKfSession($openid)
    {
        return $this->httpGet(self::PREFIX_API . self::URL_CUSTOM_SEESSION_GET . 'access_token=' . $this->access_token . '&openid=' . $openid);
    }

    /**
     * 获取指定客服的会话列表
     * @param string $kf_account //完整客服账号
     * @return boolean | array            //成功返回json数组
     *  array(
     *     'sessionlist' => array (
     *         array (
     *             'openid'=>'OPENID',             //客户 openid
     *             'createtime'=>123456789,  //会话创建时间，UNIX 时间戳
     *         ),
     *         array (
     *             'openid'=>'OPENID',             //客户 openid
     *             'createtime'=>123456789,  //会话创建时间，UNIX 时间戳
     *         ),
     *     )
     *  )
     */
    public function getKfSessionList($kf_account)
    {
        return $this->httpGet(self::PREFIX_API . self::URL_CUSTOM_SEESSION_GET_LIST . 'access_token=' . $this->access_token . '&kf_account=' . $kf_account);
    }

    /**
     * 获取未接入会话列表
     * @return boolean | array            //成功返回json数组
     *  array (
     *     'count' => 150 ,                            //未接入会话数量
     *     'waitcaselist' => array (
     *         array (
     *             'openid'=>'OPENID',             //客户 openid
     *             'kf_account ' =>'',                   //指定接待的客服，为空则未指定
     *             'createtime'=>123456789,  //会话创建时间，UNIX 时间戳
     *         ),
     *         array (
     *             'openid'=>'OPENID',             //客户 openid
     *             'kf_account ' =>'',                   //指定接待的客服，为空则未指定
     *             'createtime'=>123456789,  //会话创建时间，UNIX 时间戳
     *         )
     *     )
     *  )
     */
    public function getKfSessionWait()
    {
        return $this->httpGet(self::PREFIX_API . self::URL_CUSTOM_SEESSION_GET_WAIT . 'access_token=' . $this->access_token);
    }
}