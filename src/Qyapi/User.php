<?php


namespace Fize\Third\Wechat\Qyapi;

use Fize\Third\Wechat\QyapiAbstract;

/**
 * 成员管理
 */
class User extends QyapiAbstract
{

    /**
     * 获取部门成员
     * @param int      $department_id 部门id
     * @param int|null $fetch_child   是否递归获取子部门下面的成员：1-递归获取，0-只获取本部门
     * @return array
     */
    public function simplelist(int $department_id, int $fetch_child = null): array
    {
        $uri = "/user/simplelist?access_token=$this->accessToken&department_id=$department_id";
        if (is_null($fetch_child)) {
            $uri = $uri . "&fetch_child=$fetch_child";
        }
        return $this->httpGet($uri);
    }
}
