<?php


namespace fize\third\wechat\api;


use fize\third\wechat\Api;
use fize\crypt\Json;
use CURLFile;


/**
 * 微信多媒体管理类
 */
class Media extends Api
{
    //上传多媒体的路径
    const URL_MEDIA_UPLOAD = '/media/upload?';
    const URL_MEDIA_GET = '/media/get?';

    const URL_MEDIA_UPLOADNEWS = '/media/uploadnews?';

    const URL_MEDIA_VIDEOUPLOAD = '/media/uploadvideo?';

    //上传图片的路径
    const URL_MEDIA_UPLOADIMG = '/media/uploadimg?';

    const MEDIA_TYPE_IMAGE = 'image';
    const MEDIA_TYPE_VOICE = 'voice';
    const MEDIA_TYPE_VIDEO = 'video';
    const MEDIA_TYPE_THUMB = 'thumb';

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

    /**
     * 新增临时素材
     * 注意：上传大文件时可能需要先调用 set_time_limit(0) 避免超时
     * @param string $path 要上传的文件路径
     * @param string $type 类型：图片:image 语音:voice 视频:video 缩略图:thumb
     * @return mixed
     */
    public function upload($path, $type)
    {
        $data = [
            'media' => new CURLFile(realpath($path))
        ];
        return $this->httpPost(self::PREFIX_CGI . self::URL_MEDIA_UPLOAD . 'access_token=' . $this->access_token . '&type=' . $type, $data);
    }

    /**
     * 根据媒体文件ID获取媒体文件(认证后的订阅号可用)
     * @param string $media_id 媒体文件id
     * @return mixed data
     */
    public function get($media_id)
    {
        $result = $this->http->get(self::PREFIX_CGI . self::URL_MEDIA_GET . 'access_token=' . $this->access_token . '&media_id=' . $media_id);
        if ($result) {
            $headers = $this->http->getResponseHeaders();
            if(isset($headers['Content-Type']) && $headers['Content-Type'] == 'text/plain'){
                $json = Json::decode($result);
                if (isset($json['errcode'])) {
                    $this->errCode = $json['errcode'];
                    $this->errMsg = $json['errmsg'];
                    return false;
                }
                return [  //返回JSON
                    'type' => 'json',
                    'value' => $json
                ];
            }
            return [  //返回二进制流
                'type' => 'binary',
                'value' => $result
            ];
        }
        return false;
    }

    /**
     * 上传图文消息素材(认证后的订阅号可用)
     * @param array $data 消息结构{"articles":[{...}]}
     * @return mixed
     */
    public function uploadArticles($data)
    {
        return $this->httpPost(self::PREFIX_API . self::URL_MEDIA_UPLOADNEWS . 'access_token=' . $this->access_token, Json::encode($data, JSON_UNESCAPED_UNICODE));
    }

    /**
     * 上传视频素材(认证后的订阅号可用)
     * @param array $data 消息结构
     * {
     *     "media_id"=>"",     //通过上传媒体接口得到的MediaId
     *     "title"=>"TITLE",    //视频标题
     *     "description"=>"Description"        //视频描述
     * }
     * @return boolean|array
     * {
     *     "type":"video",
     *     "media_id":"mediaid",
     *     "created_at":1398848981
     *  }
     */
    public function uploadMpVideo($data)
    {
        return $this->httpPost(self::PREFIX_FILE . self::URL_MEDIA_VIDEOUPLOAD . 'access_token=' . $this->access_token, Json::encode($data, JSON_UNESCAPED_UNICODE));
    }

    /**
     * 上传LOGO等可用图片
     * @param string $path 要上传的文件路径
     * @return boolean|array
     */
    public function uploadImg($path)
    {
        $data = [
            'buffer' => new CURLFile(realpath($path))
        ];
        return $this->httpPost(self::PREFIX_API . self::URL_MEDIA_UPLOADIMG . 'access_token=' . $this->access_token, $data, true);
    }
}