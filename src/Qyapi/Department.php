<?php


namespace Fize\Third\Wechat\Qyapi;

use Fize\Third\Wechat\QyapiAbstract;

/**
 * 部门管理
 */
class Department extends QyapiAbstract
{

    /**
     * 获取子部门ID列表
     * @param string|null $id 部门id
     * @return array|string
     */
    public function simplelist(string $id = null)
    {
        $uri = "/department/simplelist?access_token=$this->accessToken";
        if ($id) {
            $uri = $uri . "&id=$id";
        }
        return $this->httpGet($uri);
    }
}
