<?php


namespace fize\third\wechat\api\user;

use fize\third\wechat\Api;

/**
 * 用户信息
 */
class Info extends Api
{
    /**
     * 设置用户备注名
     * @param string $openid
     * @param string $remark 备注名
     */
    public function updateremark($openid, $remark)
    {
        $params = [
            'openid' => $openid,
            'remark' => $remark
        ];
        $this->httpPost("/user/info/updateremark?access_token={$this->accessToken}", $params);
    }

    /**
     * 批量获取用户基本信息
     * @param array $users 用户列表
     * @return array
     */
    public function batchget(array $users)
    {
        $user_list = [];
        foreach ($users as $user) {
            if (is_string($user)) {
                $user_list[] = [
                    'openid' => $user
                ];
            } else {
                $user_list[] = $user;
            }
        }
        $params = [
            'user_list' => $user_list
        ];
        return $this->httpPost("/user/info/batchget?access_token={$this->accessToken}", $params);
    }
}
