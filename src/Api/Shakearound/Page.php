<?php


namespace Fize\Third\Wechat\Api\Shakearound;

use Fize\Third\Wechat\Api;

/**
 * 页面管理
 */
class Page extends Api
{

    /**
     * 新增页面信息
     * @param string $title 主标题
     * @param string $description 副标题
     * @param string $page_url 跳转URI
     * @param string $icon_url 在摇一摇页面展示的图片
     * @param string $comment 备注信息
     * @return array
     */
    public function add($title, $description, $page_url, $icon_url, $comment = null)
    {
        $params = [
            'title' => $title,
            'description' => $description,
            'page_url' => $page_url,
            'icon_url' => $icon_url
        ];
        if (!is_null($comment)) {
            $params['comment'] = $comment;
        }
        return $this->httpPost("/shakearound/page/add?access_token={$this->accessToken}", $params);
    }

    /**
     * 编辑页面洗洗
     * @param string $page_id 页面唯一ID
     * @param string $title 主标题
     * @param string $description 副标题
     * @param string $page_url 跳转URI
     * @param string $icon_url 在摇一摇页面展示的图片
     * @param string $comment 备注信息
     * @return array
     */
    public function update($page_id, $title, $description, $page_url, $icon_url, $comment = null)
    {
        $params = [
            'page_id' => $page_id,
            'title' => $title,
            'description' => $description,
            'page_url' => $page_url,
            'icon_url' => $icon_url
        ];
        if (!is_null($comment)) {
            $params['comment'] = $comment;
        }
        return $this->httpPost("/shakearound/page/update?access_token={$this->accessToken}", $params);
    }

    /**
     * 查询页面列表
     * @param array $params 参数
     * @return array
     */
    public function search(array $params)
    {
        return $this->httpPost("/shakearound/page/search?access_token={$this->accessToken}", $params);
    }

    /**
     * 删除
     * @param string $page_id 页面唯一ID
     * @return array
     */
    public function delete($page_id)
    {
        $params = [
            'page_id' => $page_id
        ];
        return $this->httpPost("/shakearound/page/search?access_token={$this->accessToken}", $params);
    }
}
