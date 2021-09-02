<?php

namespace api;

use fize\cache\CacheFactory;
use fize\third\wechat\api\Media;
use PHPUnit\Framework\TestCase;

class TestMedia extends TestCase
{

    public function testUpload()
    {
        $appid = 'wx12078319bd1c19dd';
        $appsecret = '89212483aa60a23a74ab7a11d78019f0';
        $cache = CacheFactory::create('file', ['path' => dirname(__FILE__, 3) . '/temp/cache']);
        $options = [
            'debug' => true,
        ];
        $media = new Media($appid, $appsecret, $cache, $options);

        $file = realpath(dirname(__FILE__, 3) . '/temp/bg.jpg');
        var_dump($file);
        $result = $media->upload($file, Media::MEDIA_TYPE_IMAGE);
        var_dump($result);
        self::assertIsArray($result);

        $file = realpath(dirname(__FILE__, 3) . '/temp/voice.m4a');
        var_dump($file);
        $result = $media->upload($file, Media::MEDIA_TYPE_VOICE);
        var_dump($result);
        self::assertIsArray($result);

        $file = realpath(dirname(__FILE__, 3) . '/temp/che300.mp4');
        var_dump($file);
        $result = $media->upload($file, Media::MEDIA_TYPE_VIDEO);
        var_dump($result);
        self::assertIsArray($result);
    }

    public function testGet()
    {
        $appid = 'wx12078319bd1c19dd';
        $appsecret = '89212483aa60a23a74ab7a11d78019f0';
        $cache = CacheFactory::create('file', ['path' => dirname(__FILE__, 3) . '/temp/cache']);
        $options = [
            'debug' => true,
        ];
        $media = new Media($appid, $appsecret, $cache, $options);
        $result = $media->get('6Aie3EtMOafFnDoOOYXRPhIA1KkFcE7JPvkFXAqQW1V_uCLGfasO5T_AgJmN-kKj');
        if ($result['type'] == 'json') {  // 结果返回JSON字符串
            var_dump($result['value']);
        } else {  // 结果返回二进制流
            file_put_contents(dirname(__FILE__, 3) . '/temp/bg2.jpg', $result['value']);
            echo 'OK';
        }
        self::assertIsArray($result);
    }

    public function testUploadimg()
    {
        $appid = 'wx12078319bd1c19dd';
        $appsecret = '89212483aa60a23a74ab7a11d78019f0';
        $cache = CacheFactory::create('file', ['path' => dirname(__FILE__, 3) . '/temp/cache']);
        $options = [
            'debug' => true,
        ];
        $media = new Media($appid, $appsecret, $cache, $options);
        $file = realpath(dirname(__FILE__, 3) . '/temp/bg.jpg');
        var_dump($file);
        $result = $media->uploadimg($file);
        var_dump($result);
        self::assertIsString($result);
    }

    public function testUploadnews()
    {
        $appid = 'wx12078319bd1c19dd';
        $appsecret = '89212483aa60a23a74ab7a11d78019f0';
        $cache = CacheFactory::create('file', ['path' => dirname(__FILE__, 3) . '/temp/cache']);
        $options = [
            'debug' => true,
        ];
        $media = new Media($appid, $appsecret, $cache, $options);

        $file = realpath(dirname(__FILE__, 3) . '/temp/bg.jpg');
        var_dump($file);
        $result = $media->upload($file, Media::MEDIA_TYPE_THUMB);
        var_dump($result);
        self::assertIsArray($result);

        $articles = [
            [
            "thumb_media_id" => "eqpYRBjbtrAxSqnVviKlUVH_krJNdu2AQlyPjbosbtvhEOegwLZWU0wU8OeBdeZR",
            "author" => "xxx",
            "title" => "Happy Day",
            "content_source_url" => "www.qq.com",
            "content" =>"content",
            "digest" => "digest",
            "show_cover_pic" => 1,
            "need_open_comment" => 1,
            "only_fans_can_comment" => 1
            ], [
            "thumb_media_id" => "eqpYRBjbtrAxSqnVviKlUVH_krJNdu2AQlyPjbosbtvhEOegwLZWU0wU8OeBdeZR",
            "author" => "xxx",
            "title" => "Happy Day",
            "content_source_url" => "www.qq.com",
            "content" => "content",
            "digest" => "digest",
            "show_cover_pic" => 0,
            "need_open_comment" => 1,
            "only_fans_can_comment" => 1
            ]
        ];
        $result = $media->uploadnews($articles);
        var_dump($result);
        self::assertIsArray($result);
    }

    /**
     * @todo 20210902测试未通过
     */
    public function testUploadvideo()
    {
        $appid = 'wx12078319bd1c19dd';
        $appsecret = '89212483aa60a23a74ab7a11d78019f0';
        $cache = CacheFactory::create('file', ['path' => dirname(__FILE__, 3) . '/temp/cache']);
        $options = [
            'debug' => true,
        ];
        $media = new Media($appid, $appsecret, $cache, $options);
        $file = realpath(dirname(__FILE__, 3) . '/temp/che300.mp4');
        var_dump($file);
        $result = $media->uploadvideo($file);
        var_dump($result);
        self::assertIsArray($result);
    }
}
