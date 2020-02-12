<?php


namespace fize\third\wechat\api;

use CURLFile;
use fize\crypt\Json;
use fize\net\Http;
use fize\third\wechat\Api;


/**
 * 临时素材
 */
class Media extends Api
{
    const MEDIA_TYPE_IMAGE = 'image';
    const MEDIA_TYPE_VOICE = 'voice';
    const MEDIA_TYPE_VIDEO = 'video';
    const MEDIA_TYPE_THUMB = 'thumb';

    /**
     * 新增临时素材
     * 注意：上传大文件时可能需要先调用 set_time_limit(0) 避免超时
     * @param string $file 要上传的文件
     * @param string $type 类型：图片:image 语音:voice 视频:video 缩略图:thumb
     * @return array|false 失败返回false
     */
    public function upload($file, $type)
    {
        $params = [
            'media' => new CURLFile(realpath($file))
        ];
        return $this->httpPost("/media/upload?access_token={$this->accessToken}&type={$type}", $params, false);
    }

    /**
     * 获取临时素材
     * @param string $media_id 媒体文件ID
     * @return array|false 失败返回false
     */
    public function get($media_id)
    {
        $result = $this->httpGet("/media/get?access_token={$this->accessToken}&media_id={$media_id}");
        if ($result) {
            $ContentType = Http::getLastResponse()->getHeaderLine('Content-Type');
            if ($ContentType == 'text/plain') {
                $json = Json::decode($result);
                if (isset($json['errcode'])) {
                    $this->errCode = $json['errcode'];
                    $this->errMsg = $json['errmsg'];
                    return false;
                }
                return [  //返回JSON
                    'type'  => 'json',
                    'value' => $json
                ];
            }
            return [  //返回二进制流
                'type'  => 'binary',
                'value' => $result
            ];
        }
        return false;
    }

    /**
     * 上传图文消息内的图片获取URL
     * @param string $file 要上传的文件
     * @return string|false 成功返回URI失败返回false
     */
    public function uploadImg($file)
    {
        $params = [
            'media' => new CURLFile(realpath($file))
        ];
        $json = $this->httpPost("/media/uploadimg?access_token={$this->accessToken}", $params, false);
        if (!$json) {
            return false;
        }
        return $json['url'];
    }
}
