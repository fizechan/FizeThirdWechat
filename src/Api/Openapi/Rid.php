<?php

namespace Fize\Third\Wechat\Api\Openapi;

use Fize\Third\Wechat\ApiAbstract;

/**
 * rid管理
 */
class Rid extends ApiAbstract
{

    /**
     * 查询rid信息
     * @param string $rid 调用接口报错返回的rid
     * @return array
     * @see https://developers.weixin.qq.com/doc/offiaccount/openApi/get_rid_info.html
     */
    public function get(string $rid): array
    {
        $params = [
            'rid' => $rid
        ];
        $result = $this->httpPost("/openapi/rid/get?access_token=$this->accessToken", $params);
        return $result['request'];
    }
}