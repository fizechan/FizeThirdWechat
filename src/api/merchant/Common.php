<?php


namespace fize\third\wechat\api\merchant;

use CURLFile;
use fize\third\wechat\Api;

/**
 * 功能接口
 */
class Common extends Api
{
    /**
     * 上传图文消息内的图片获取URL
     * @param string $file 要上传的文件
     * @param string $name 自定义文件名
     * @return string 返回URI
     */
    public function uploadimg($file, $name = null)
    {
        if (is_null($name)) {
            $name = basename($file);
        }
        $name = urlencode($name);
        $params = [
            'media' => new CURLFile(realpath($file))
        ];
        $result = $this->httpPost("/merchant/common/upload_img?access_token={$this->accessToken}&filename{$name}", $params, false);
        return $result['image_url'];
    }
}
