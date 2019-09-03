<?php


namespace fize\third\wechat\api;


use fize\third\wechat\Api;
use fize\crypt\Json;


/**
 * 微信用户管理类
 */
class User extends Api
{

    const URL_USER_UPDATEREMARK = '/user/info/updateremark?';

    const URL_USER_INFO = '/user/info?';

    const URL_USER_GET = '/user/get?';

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
     * 设置用户备注名
     * @param string $openid
     * @param string $remark 备注名
     * @return boolean|array
     */
    public function updateUserRemark($openid, $remark)
    {
        $data = array(
            'openid' => $openid,
            'remark' => $remark
        );
        return $this->httpPost(self::PREFIX_API . self::URL_USER_UPDATEREMARK . 'access_token=' . $this->access_token, Json::encode($data, JSON_UNESCAPED_UNICODE));
    }

    /**
     * 获取用户基本信息
     * @param string $openid
     * @return array {subscribe,openid,nickname,sex,city,province,country,language,headimgurl,subscribe_time,[unionid]}
     * 注意：unionid字段 只有在用户将公众号绑定到微信开放平台账号后，才会出现。建议调用前用isset()检测一下
     */
    public function getUserInfo($openid)
    {
        return $this->httpGet(self::PREFIX_API . self::URL_USER_INFO . 'access_token=' . $this->access_token . '&openid=' . $openid);
    }

    /**
     * 获取用户列表
     * @param string $next_openid
     * @return mixed
     */
    public function getUserList($next_openid = '')
    {
        return $this->httpGet(self::PREFIX_API . self::URL_USER_GET . 'access_token=' . $this->access_token . '&next_openid=' . $next_openid);
    }
}