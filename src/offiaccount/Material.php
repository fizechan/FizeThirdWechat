<?php

namespace fize\third\wechat\offiaccount;

use CURLFile;
use fize\crypt\Json;
use fize\net\Http;
use fize\third\wechat\Offiaccount;


/**
 * 永久素材
 */
class Material extends Offiaccount
{
    const MEDIA_TYPE_IMAGE = 'image';
    const MEDIA_TYPE_VOICE = 'voice';
    const MEDIA_TYPE_VIDEO = 'video';
    const MEDIA_TYPE_THUMB = 'thumb';

    /**
     * 新增永久图文素材
     * @param string $title 标题
     * @param string $thumb_media_id 图文消息的封面图片素材ID
     * @param int $show_cover_pic 是否显示封面，0为false，即不显示，1为true，即显示
     * @param string $content 图文消息的具体内容
     * @param string $content_source_url 图文消息的原文地址
     * @param string $author 作者
     * @param string $digest 图文消息的摘要
     * @param int $need_open_comment 是否打开评论，0不打开，1打开
     * @param int $only_fans_can_comment 是否粉丝才可评论，0所有人可评论，1粉丝才可评论
     * @return string|false 成功返回素材ID，失败返回false
     */
    public function addNews($title, $thumb_media_id, $show_cover_pic, $content, $content_source_url, $author = null, $digest = null, $need_open_comment = null, $only_fans_can_comment = null)
    {
        $params = [
            'title'              => $title,
            'thumb_media_id'     => $thumb_media_id,
            'show_cover_pic'     => $show_cover_pic,
            'content'            => $content,
            'content_source_url' => $content_source_url
        ];
        if (!is_null($author)) {
            $params['author'] = $author;
        }
        if (!is_null($digest)) {
            $params['digest'] = $digest;
        }
        if (!is_null($need_open_comment)) {
            $params['need_open_comment'] = $need_open_comment;
        }
        if (!is_null($only_fans_can_comment)) {
            $params['only_fans_can_comment'] = $only_fans_can_comment;
        }
        $json = $this->httpPost("/material/add_news?access_token={$this->accessToken}", $params);
        if (!$json) {
            return false;
        }
        return $json['media_id'];
    }

    /**
     * 新增其他类型永久素材
     * @param string $type 类型
     * @param string $file 要上传的文件
     * @param string $title 视频素材的标题
     * @param string $introduction 视频素材的描述
     * @return array|false 失败时返回false
     */
    public function addMaterial($type, $file, $title = null, $introduction = null)
    {
        $params = [
            'media' => new CURLFile(realpath($file))
        ];
        if ($type == self::MEDIA_TYPE_VIDEO) {
            $description = [
                'title'        => $title,
                'introduction' => $introduction
            ];
            $params['description'] = Json::encode($description, JSON_UNESCAPED_UNICODE);
        }
        return $this->httpPost("/material/add_material?access_token={$this->accessToken}&type={$type}", $params, false);
    }

    /**
     * 获取永久素材
     * @param string $media_id 素材的media_id
     * @return array|false 失败时返回false
     */
    public function getMaterial($media_id)
    {
        $params = [
            'media_id' => $media_id
        ];
        $result = $this->httpPost("/material/get_material?access_token={$this->accessToken}", $params);
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
     * 删除永久素材
     * @param string $media_id 素材的media_id
     * @return bool
     */
    public function delMaterial($media_id)
    {
        $params = [
            'media_id' => $media_id
        ];
        $result = $this->httpPost("/material/del_material?access_token={$this->accessToken}", $params);
        return $result ? true : false;
    }

    /**
     * 修改永久图文素材
     * @param string $media_id 要修改的图文消息的id
     * @param int $index 要更新的文章在图文消息中的位置
     * @param string $title 标题
     * @param string $thumb_media_id 图文消息的封面图片素材id
     * @param string $author 作者
     * @param string $digest 图文消息的摘要
     * @param int $show_cover_pic 是否显示封面，0为false，即不显示，1为true，即显示
     * @param string $content 图文消息的具体内容
     * @param string $content_source_url 图文消息的原文地址
     * @return bool
     */
    public function updateNews($media_id, $index, $title, $thumb_media_id, $author, $digest, $show_cover_pic, $content, $content_source_url)
    {
        $params = [
            'media_id'           => $media_id,
            'index'              => $index,
            'title'              => $title,
            'thumb_media_id'     => $thumb_media_id,
            'author'             => $author,
            'digest'             => $digest,
            'show_cover_pic'     => $show_cover_pic,
            'content'            => $content,
            'content_source_url' => $content_source_url
        ];
        $result = $this->httpPost("/material/update_news?access_token={$this->accessToken}", $params);
        return $result ? true : false;
    }

    /**
     * 获取素材总数
     * @return array|false 失败返回false
     */
    public function getMaterialCount()
    {
        return $this->httpGet("/material/get_materialcount?access_token={$this->accessToken}");
    }

    /**
     * 获取素材列表
     * @param string $type 类型
     * @param int $offset 偏移位置
     * @param int $count 返回素材的数量
     * @return array|false 失败时返回false
     */
    public function batchGetMaterial($type, $offset, $count)
    {
        $params = [
            'type'   => $type,
            'offset' => $offset,
            'count'  => $count,
        ];
        return $this->httpPost("/material/batchget_material?access_token={$this->accessToken}", $params);
    }
}
