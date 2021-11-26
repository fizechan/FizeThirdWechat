<?php


namespace Fize\Third\Wechat\Api\Shakearound;

use CURLFile;
use Fize\Third\Wechat\Api;

/**
 * 图片素材
 */
class Material extends Api
{

    /**
     * 上传图片素材
     * @param string $media 要上传的文件
     * @param string $type 图片类型
     * @return array
     */
    public function add($media, $type = null)
    {
        $params = [
            'media' => new CURLFile(realpath($media))
        ];
        if (!is_null($type)) {
            $params['type'] = $type;
        }
        return $this->httpPost("/shakearound/material/add?access_token={$this->accessToken}&type={$type}", $params, false);
    }
}
