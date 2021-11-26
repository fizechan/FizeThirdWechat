<?php


namespace Fize\Third\Wechat\Api\CV;

use CURLFile;
use Fize\Third\Wechat\Api;

/**
 * OCR识别
 */
class OCR extends Api
{

    /**
     * 身份证OCR识别
     * @param string $img 身份证图片
     * @return array
     */
    public function idcard($img)
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
        return $this->httpPost("/cv/ocr/idcard?access_token={$this->accessToken}", $params, $params_json_encode);
    }

    /**
     * 银行卡OCR识别
     * @param string $img 银行卡图片
     * @return array
     */
    public function bankcard($img)
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
        return $this->httpPost("/cv/ocr/bankcard?access_token={$this->accessToken}", $params, $params_json_encode);
    }

    /**
     * 行驶证OCR识别
     * @param string $img 行驶证图片
     * @return array
     */
    public function driving($img)
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
        return $this->httpPost("/cv/ocr/driving?access_token={$this->accessToken}", $params, $params_json_encode);
    }

    /**
     * 驾驶证OCR识别
     * @param string $img 驾驶证图片
     * @return array
     */
    public function drivinglicense($img)
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
        return $this->httpPost("/cv/ocr/drivinglicense?access_token={$this->accessToken}", $params, $params_json_encode);
    }

    /**
     * 营业执照OCR识别
     * @param string $img 营业执照图片
     * @return array
     */
    public function bizlicense($img)
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
        return $this->httpPost("/cv/ocr/bizlicense?access_token={$this->accessToken}", $params, $params_json_encode);
    }

    /**
     * 通用印刷体OCR识别
     * @param string $img 图片
     * @return array
     */
    public function comm($img)
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
        return $this->httpPost("/cv/ocr/comm?access_token={$this->accessToken}", $params, $params_json_encode);
    }
}
