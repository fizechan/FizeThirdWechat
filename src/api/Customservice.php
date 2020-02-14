<?php


namespace fize\third\wechat\offiaccount;

use fize\third\wechat\Offiaccount;

/**
 * 客服信息
 */
class Customservice extends Offiaccount
{

    /**
     * 获取所有客服账号
     * @return array|false
     */
    public function getkflist()
    {
        return $this->httpGet("/customservice/getkflist?access_token={$this->accessToken}");
    }
}
