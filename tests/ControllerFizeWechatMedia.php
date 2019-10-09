<?php

namespace app\controller;

use fize\cache\Cache;
use fize\loger\Log;
use fize\third\wechat\api\Media;


class ControllerFizeWechatMedia
{
    private $wxconfig;

    public function __construct()
    {
        //CACHE初始化
        Cache::init('file');
        //Loger初始化
        Log::init('file');

        $this->wxconfig = [
            'appid' => 'wx12078319bd1c19dd',
            'appsecret' => '89212483aa60a23a74ab7a11d78019f0',
            'debug' => true
        ];
    }

    public function actionUpload()
    {
        $file = 'H:\WEB\www.sygame.loc\src\static\game\bafang\common\image\cancel.png';
        $media = new Media($this->wxconfig);
        $result = $media->upload($file, Media::MEDIA_TYPE_IMAGE);
        var_dump($result);
        var_dump($media->errCode);
        var_dump($media->errMsg);
	}

    public function actionGet()
    {
        $media = new Media($this->wxconfig);
        $result = $media->get('_xiTlteQRyKM6KKbYB5iRzXlJF6J_llTlk-_RWq9yhiF6LM7ZLvYctC5WQ05TGpA');
        if($result['type'] == 'json'){  //结果返回JSON字符串
            var_dump($result['value']);
        }else{  //结果返回二进制流
            file_put_contents('upload.png', $result['value']);
            echo 'OK';
        }
    }
}
