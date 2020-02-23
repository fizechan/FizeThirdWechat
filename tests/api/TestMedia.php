<?php

namespace api;

use fize\third\wechat\api\Media;
use PHPUnit\Framework\TestCase;

class TestMedia extends TestCase
{

    public function testUpload()
    {
        $config = [
            'appid' => 'wx12078319bd1c19dd',
            'appsecret' => '89212483aa60a23a74ab7a11d78019f0'
        ];
        $file = 'H:\WEB\www.sygame.loc\src\static\game\bafang\common\image\cancel.png';
        $media = new Media($config);
        $result = $media->upload($file, Media::MEDIA_TYPE_IMAGE);
        var_dump($result);
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

    public function testGet()
    {
        $config = [
            'appid' => 'wx12078319bd1c19dd',
            'appsecret' => '89212483aa60a23a74ab7a11d78019f0'
        ];
        $media = new Media($config);
        $result = $media->get('_xiTlteQRyKM6KKbYB5iRzXlJF6J_llTlk-_RWq9yhiF6LM7ZLvYctC5WQ05TGpA');
        if($result['type'] == 'json'){  //结果返回JSON字符串
            var_dump($result['value']);
        }else{  //结果返回二进制流
            file_put_contents('upload.png', $result['value']);
            echo 'OK';
        }
    }
}
