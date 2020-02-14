<?php


namespace fize\third\wechat\api;

use fize\third\wechat\Api;

/**
 * 客服信息
 */
class Customservice extends Api
{

    /**
     * 获取所有客服账号
     * @return array
     */
    public function getkflist()
    {
        $result = $this->httpGet("/customservice/getkflist?access_token={$this->accessToken}");
        return $result['kf_list'];
    }
}
