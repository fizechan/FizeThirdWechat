<?php


namespace fize\third\wechat\api\user;

use fize\third\wechat\Api;

/**
 * 用户标签
 */
class Tag extends Api
{
    /**
     * 获取标签下粉丝列表
     * @param int $tagid 标签ID
     * @param string $next_openid 第一个拉取的OPENID，不填默认从头开始拉取
     * @return array
     */
    public function get($tagid, $next_openid = '')
    {
        $params = [
            'tagid'       => $tagid,
            'next_openid' => $next_openid
        ];
        return $this->httpPost("/user/tag/get?access_token={$this->accessToken}", $params);
    }
}
