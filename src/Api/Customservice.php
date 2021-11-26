<?php

namespace Fize\Third\Wechat\Api;

use Fize\Third\Wechat\ApiAbstract;

/**
 * 客服信息
 */
class Customservice extends ApiAbstract
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
