<?php


namespace fize\third\wechat\api\cv;

use CURLFile;
use fize\third\wechat\Api;

/**
 * 图像处理
 */
class Img extends Api
{
    /**
     * 二维码/条码识别
     * @param string $img 图片
     * @return array
     */
    public function qrcode($img)
    {
        // "scheme://..." 的格式
        if (strstr($img, '://') !== false && substr($img, 0, 4) != 'file') {
            $params = [
                'img_url' => $img
            ];
            $params_json_encode = false;
        } else {
            $params = [
                'img' => new CURLFile(realpath($img))
            ];
            $params_json_encode = true;
        }
        return $this->httpPost("/cv/img/qrcode?access_token={$this->accessToken}", $params, $params_json_encode);
    }

    /**
     * 图片高清化
     * @param string $img 图片
     * @return array
     */
    public function superresolution($img)
    {
        // "scheme://..." 的格式
        if (strstr($img, '://') !== false && substr($img, 0, 4) != 'file') {
            $params = [
                'img_url' => $img
            ];
            $params_json_encode = false;
        } else {
            $params = [
                'img' => new CURLFile(realpath($img))
            ];
            $params_json_encode = true;
        }
        return $this->httpPost("/cv/img/superresolution?access_token={$this->accessToken}", $params, $params_json_encode);
    }

    /**
     * 图片智能裁剪
     * @param string $img 图片
     * @return array
     */
    public function aicrop($img)
    {
        // "scheme://..." 的格式
        if (strstr($img, '://') !== false && substr($img, 0, 4) != 'file') {
            $params = [
                'img_url' => $img
            ];
            $params_json_encode = false;
        } else {
            $params = [
                'img' => new CURLFile(realpath($img))
            ];
            $params_json_encode = true;
        }
        return $this->httpPost("/cv/img/aicrop?access_token={$this->accessToken}", $params, $params_json_encode);
    }
}
