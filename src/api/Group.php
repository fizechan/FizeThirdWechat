<?php


namespace fize\third\wechat\api;


use fize\third\wechat\Api;
use fize\crypt\Json;


/**
 * 微信用户分组管理类
 */
class Group extends Api
{

    const URL_GROUP_CREATE = '/groups/create?';

    const URL_GROUP_GET = '/groups/get?';

    const URL_USER_GROUP = '/groups/getid?';

    const URL_GROUP_UPDATE = '/groups/update?';

    const URL_GROUP_MEMBER_UPDATE = '/groups/members/update?';
    const URL_GROUP_MEMBER_BATCHUPDATE = '/groups/members/batchupdate?';

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
     * 创建分组,新增自定分组
     * @param string $name 分组名称
     * @return boolean|array
     */
    public function createGroup($name)
    {
        $data = array(
            'group' => array('name' => $name)
        );
        return $this->httpPost(self::PREFIX_CGI . self::URL_GROUP_CREATE . 'access_token=' . $this->access_token, Json::encode($data, JSON_UNESCAPED_UNICODE));
    }

    /**
     * 查询所有分组
     * @return boolean|array
     */
    public function getGroup()
    {
        return $this->httpget(self::PREFIX_CGI . self::URL_GROUP_GET . 'access_token=' . $this->access_token);
    }

    /**
     * 获取用户所在分组
     * @param string $openid
     * @return boolean|int 成功则返回用户分组id
     */
    public function getUserGroup($openid)
    {
        $data = array(
            'openid' => $openid
        );
        $json = $this->httpPost(self::PREFIX_CGI . self::URL_USER_GROUP . 'access_token=' . $this->access_token, Json::encode($data));
        if ($json) {
            if (isset($json['groupid'])) {
                return $json['groupid'];
            }
        }
        return false;
    }

    /**
     * 修改分组名
     * @param int $groupid 分组id
     * @param string $name 分组名称
     * @return boolean|array
     */
    public function updateGroup($groupid, $name)
    {
        $data = array(
            'group' => array('id' => $groupid, 'name' => $name)
        );
        $t_rst = $this->httpPost(self::PREFIX_CGI . self::URL_GROUP_UPDATE . 'access_token=' . $this->access_token, Json::encode($data, JSON_UNESCAPED_UNICODE));
        if ($t_rst) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 移动用户分组
     * @param int $groupid 分组id
     * @param string $openid 用户openid
     * @return boolean|array
     */
    public function updateGroupMembers($groupid, $openid)
    {
        $data = array(
            'openid' => $openid,
            'to_groupid' => $groupid
        );
        $t_rst = $this->httpPost(self::PREFIX_CGI . self::URL_GROUP_MEMBER_UPDATE . 'access_token=' . $this->access_token, Json::encode($data));
        if ($t_rst) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 批量移动用户分组
     * @param int $groupid 分组id
     * @param array $openid_list 用户openid数组,一次不能超过50个
     * @return boolean|array
     */
    public function batchUpdateGroupMembers($groupid, $openid_list)
    {
        $data = array(
            'openid_list' => $openid_list,
            'to_groupid' => $groupid
        );
        return $this->httpPost(self::PREFIX_CGI . self::URL_GROUP_MEMBER_BATCHUPDATE . 'access_token=' . $this->access_token, Json::encode($data));
    }
}