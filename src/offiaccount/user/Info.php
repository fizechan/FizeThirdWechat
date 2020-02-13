<?php


namespace fize\third\wechat\offiaccount\user;

use fize\third\wechat\Offiaccount;

/**
 * 用户信息
 */
class Info extends Offiaccount
{
    /**
     * 设置用户备注名
     * @param string $openid
     * @param string $remark 备注名
     * @return bool
     */
    public function updateremark($openid, $remark)
    {
        $params = [
            'openid' => $openid,
            'remark' => $remark
        ];
        $result = $this->httpPost("/user/info/updateremark?access_token={$this->accessToken}", $params);
        return $result ? true : false;
    }

    /**
     * 批量获取用户基本信息
     * @param array $users 用户列表
     * @return array|false
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
