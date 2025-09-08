<?php

namespace Fize\Third\Wechat\Api\Openapi;

use Fize\Third\Wechat\ApiAbstract;

/**
 * quota管理
 */
class Quota extends ApiAbstract
{

    /**
     * 查询API调用额度
     *
     * 参数 `$cgi_path`:
     *   例如"/cgi-bin/message/custom/send";不要前缀“https://api.weixin.qq.com” ，也不要漏了"/",否则都会76003的报错
     * @param string $cgi_path api的请求地址
     * @return array
     * @see https://developers.weixin.qq.com/doc/offiaccount/openApi/get_api_quota.html
     */
    public function get(string $cgi_path): array
    {
        $params = [
            'cgi_path' => $cgi_path
        ];
        $result = $this->httpPost("/openapi/quota/get?access_token=$this->accessToken", $params);
        return $result['quota'];
    }
}