<?php

namespace api;

use fize\third\wechat\api\Media;
use PHPUnit\Framework\TestCase;

class TestMedia extends TestCase
{

    public function testUpload()
    {
        $config = [
            'appid'     => 'wx12078319bd1c19dd',
            'appsecret' => '89212483aa60a23a74ab7a11d78019f0',
            'debug'     => true,
            'cache'     => [
                'handler' => 'file',
                'config'  => [
                    'path' => __DIR__ . '/../../temp/cache',
                ]
            ]
        ];
        $file = 'H:\web\shangyi\www.sygame.loc\src\static\index\bafang\index\image\bg.jpg';
        $media = new Media($config);
        $result = $media->upload($file, Media::MEDIA_TYPE_IMAGE);
        var_dump($result);
        self::assertIsArray($result);
    }

    public function testGet()
    {
        $config = [
            'appid'     => 'wx12078319bd1c19dd',
            'appsecret' => '89212483aa60a23a74ab7a11d78019f0',
            'debug'     => true,
            'cache'     => [
                'handler' => 'file',
                'config'  => [
                    'path' => __DIR__ . '/../../temp/cache',
                ]
            ]
        ];
        $media = new Media($config);
        $result = $media->get('NhiUuMsBILgIiMv-YGkBurHMO002nvYMmicbEmblZVu_0_AlmShLjiBnnDPPYnWO');
        if ($result['type'] == 'json') {  //结果返回JSON字符串
            var_dump($result['value']);
        } else {  //结果返回二进制流
            file_put_contents(__DIR__ . '/../../temp/bg.jpg', $result['value']);
            echo 'OK';
        }
        self::assertIsArray($result);
    }

    public function testUploadimg()
    {

    }

    public function testUploadvideo()
    {

    }

    public function testUploadnews()
    {

    }


}
