<?php

namespace fize\third\wechat\api;

use fize\third\wechat\Api;
use CURLFile;

/**
 * 永久素材管理类
 * Class Material
 */
class Material extends Api
{
    const URL_MATERIAL_ADD_NEWS = '/material/add_news?';

    /**
     * 构造函数
     * @param array $p_options 参数数组
     */
    public function __construct(array $p_options)
    {
        parent::__construct($p_options);
        //检测TOKEN
        $this->checkAccessToken();
    }

    public function addNews($title, $thumb_media_id, $show_cover_pic, $content, $content_source_url, $author = null, $digest = null)
    {

    }
}