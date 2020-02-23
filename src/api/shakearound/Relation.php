<?php


namespace fize\third\wechat\api\shakearound;

use fize\third\wechat\Api;

/**
 * 设备与页面的关联关系
 */
class Relation extends Api
{

    /**
     * 查询关联关系
     * @param array $params 参数
     * @return array
     */
    public function search(array $params)
    {
        return $this->httpPost("/shakearound/relation/search?access_token={$this->accessToken}", $params);
    }
}
