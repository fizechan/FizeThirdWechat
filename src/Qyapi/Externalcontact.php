<?php


namespace Fize\Third\Wechat\Qyapi;

use Fize\Third\Wechat\QyapiAbstract;

/**
 * 客户联系
 */
class Externalcontact extends QyapiAbstract
{

    /**
     * 获取配置了客户联系功能的成员列表
     * @return array
     */
    public function getFollowUserList(): array
    {
        $result = $this->httpGet("/externalcontact/get_follow_user_list?access_token=$this->accessToken");
        return $result['follow_user'];
    }
}
