<?php


namespace fize\third\wechat\api\merchant;

use fize\third\wechat\Api;

/**
 * 货架管理
 */
class Shelf extends Api
{

    /**
     * 增加货架
     * @param string $shelf_name 货架名称
     * @param array $shelf_data 货架信息
     * @param string $shelf_banner 货架招牌图片Url
     * @return string
     */
    public function add($shelf_name, array $shelf_data, $shelf_banner = null)
    {
        $params = [
            'shelf_name' => $shelf_name,
            'shelf_data' => $shelf_data
        ];
        if (!is_null($shelf_banner)) {
            $params['shelf_banner'] = $shelf_banner;
        }
        return $this->httpPost("/merchant/shelf/add?access_token={$this->accessToken}", $params);
    }

    /**
     * 删除货架
     * @param int $shelf_id 货架ID
     * @return bool
     */
    public function del($shelf_id)
    {
        $params = [
            'shelf_id' => $shelf_id
        ];
        return $this->httpPost("/merchant/shelf/del?access_token={$this->accessToken}", $params);
    }

    /**
     * 修改货架
     * @param int $shelf_id 货架ID
     * @param string $shelf_name 货架名称
     * @param array $shelf_data 货架信息
     * @param string $shelf_banner 货架招牌图片Url
     * @return bool
     */
    public function mod($shelf_id, $shelf_name = null, array $shelf_data = null, $shelf_banner = null)
    {
        $params = [
            'shelf_id' => $shelf_id
        ];
        if (!is_null($shelf_name)) {
            $params['shelf_name'] = $shelf_name;
        }
        if (!is_null($shelf_data)) {
            $params['shelf_data'] = $shelf_data;
        }
        if (!is_null($shelf_banner)) {
            $params['shelf_banner'] = $shelf_banner;
        }
        return $this->httpPost("/merchant/shelf/mod?access_token={$this->accessToken}", $params);
    }

    /**
     * 获取所有货架
     * @return array
     */
    public function getall()
    {
        return $this->httpGet("/merchant/shelf/getall?access_token={$this->accessToken}");
    }

    /**
     * 根据货架ID获取货架信息
     * @param int $shelf_id 货架ID
     * @return array
     */
    public function getbyid($shelf_id)
    {
        $params = [
            'shelf_id' => $shelf_id
        ];
        return $this->httpPost("/merchant/shelf/getbyid?access_token={$this->accessToken}", $params);
    }
}
