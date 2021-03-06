<?php


namespace fize\third\wechat\api;

use CURLFile;
use fize\crypt\Json;
use fize\third\wechat\Api;
use fize\third\wechat\ApiException;


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
     * @return array
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
     * @return array ['type' => *, 'value' => *]
     */
    public function get($media_id)
    {
        $result = $this->httpGet("/media/get?access_token={$this->accessToken}&media_id={$media_id}", false);
        $ContentType = $this->response->getHeaderLine('Content-Type');
        if ($ContentType == 'text/plain') {
            $json = Json::decode($result);
            if (isset($json['errcode']) && $json['errcode']) {
                throw new ApiException($json['errmsg'], $json['errcode']);
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

    /**
     * 上传图文消息内的图片获取URL
     * @param string $file 要上传的文件
     * @return string 返回URI
     */
    public function uploadimg($file)
    {
        $params = [
            'media' => new CURLFile(realpath($file))
        ];
        $result = $this->httpPost("/media/uploadimg?access_token={$this->accessToken}", $params, false);
        return $result['url'];
    }

    /**
     * 上传图文消息素材
     * @param array $articles 图文消息
     * @return array
     */
    public function uploadnews(array $articles)
    {
        $params = [
            'articles' => $articles
        ];
        return $this->httpPost("/media/uploadnews?access_token={$this->accessToken}", $params);
    }

    /**
     * 上传视频素材
     * @param string $file 要上传的文件
     * @return array
     */
    public function uploadvideo($file)
    {
        $params = [
            'media' => new CURLFile(realpath($file))
        ];
        return $this->httpPost("/media/uploadvideo?access_token={$this->accessToken}", $params, false);
    }
}
