<?php


namespace fize\third\wechat\api\semantic;

use fize\third\wechat\Api;

/**
 * 语义理解
 */
class Semproxy extends Api
{

    /**
     * 发送语义理解请求
     * @param string $query 输入字符串
     * @param string $category 需要使用的服务类型
     * @param array $extend 其他字段
     * @return array
     */
    public function search($query, $category, array $extend)
    {
        $params = [
            'query' => $query,
            'category' => $category,
            'appid' => $this->appid
        ];
        $params = array_merge($params, $extend);
        return $this->httpPost("/semantic/semproxy/search?access_token={$this->accessToken}", $params);
    }
}
